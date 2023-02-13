<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\bootstrap5\Html;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;

    const STATUS_ACTIVE = 10;

    const BASE_USER_ROLE = 'base_user';

    public array $rules = [];

    const CAN_USE_CART = 'can_use_cart';

    const CAN_VIEW_COST = 'can_view_cost';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Имя пользователя',
            'password_hash' => 'хэш',
            'password_reset_token' => 'токен',
            'email' => 'Почта',
            'auth_key' => 'ключ авторизации',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
            'password' => 'Пароль',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     *
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     *
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     *
     * @throws Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public static function findByPasswordResetToken($token)
    {

        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function isPasswordResetTokenValid($token)
    {

        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getRoles()
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRolesByUser($this->id), 'name', 'name');
    }

    /** updating the role when updating the user
     *
     * @param array $newRoles added roles
     * @param array $oldRoles deleted roles
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function updateRoles(array $newRoles, array $oldRoles): bool
    {
        $this->deleteRoles(array_diff($oldRoles, $newRoles));
        $this->addRoles(array_diff($newRoles, $oldRoles));
        return true;
    }

    /** delete role for user
     *
     * @param array $roles roles for delete
     *
     * @return boolean
     */
    public function deleteRoles(array $roles): bool
    {
        $auth = Yii::$app->authManager;
        foreach ($roles as $role) {
            $deletedRole = $auth->getRole($role);
            $auth->revoke($deletedRole, $this->id);
        }
        return true;
    }

    /** add new role for user
     *
     * @param array $roles roles for add
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function addRoles(array $roles): bool
    {
        $auth = Yii::$app->authManager;
        foreach ($roles as $role) {
            $addedRole = $auth->getRole($role);
            $auth->assign($addedRole, $this->id);
        }
        return true;
    }

    /**
     * @return string
     */
    public static function generateLogoutButton(): string
    {
        $userName = Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->username;
        return Html::beginForm(['/user/logout'], 'post', ['class' => 'form-inline'])
            . Html::submitButton(
                "Logout ($userName)",
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm();
    }

    /**
     * @return int
     */
    public static function getUserPagination(): int
    {
        $pageSize = 40;
        $userPagination = Yii::$app->request->cookies->get('productsPagination');
        if (!empty($userPagination)) {
            $pageSize = (int)$userPagination->value;
        }

        return $pageSize;
    }

    /**
     * @return int
     */
    public function deleteAllUserRules(): int
    {
        return AuthAssignment::deleteAll(['user_id' => $this->id]);
    }

    /**
     * @return array
     */
    public function getUserRoles(): array
    {
        return AuthAssignment::find()->where(['user_id' => Yii::$app->user->id])->all();
    }

    public function canUser(string $ruleName): bool
    {
        $access = false;

        if (Yii::$app->user->isGuest) {
            return $access;
        }

        $userRoles = $this->getUserRoles();

        /** @var AuthAssignment $role */
        foreach ($userRoles as $role) {
            $rolesIds[] = $role->item_name;
        }

        $userAuthItems = AuthItem::getByRolesNames($rolesIds);

        /** @var AuthItem $role */
        if (!empty($userAuthItems)) {
            foreach ($userAuthItems as $userAuthItem) {
                $rules = json_decode($userAuthItem->rules, true);
                if (isset($rules[$ruleName]) && $rules[$ruleName] === true) {
                    $access = true;
                }
            }
        }

        return $access;
    }
}