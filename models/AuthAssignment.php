<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "auth_assignment".
 *
 * @property string $item_name
 * @property string $user_id
 * @property int|null $created_at
 *
 * @property AuthItem $itemName
 */
class AuthAssignment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_assignment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_name', 'user_id'], 'required'],
            [['created_at'], 'integer'],
            [['item_name', 'user_id'], 'string', 'max' => 64],
            [['item_name', 'user_id'], 'unique', 'targetAttribute' => ['item_name', 'user_id']],
            [['item_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::class, 'targetAttribute' => ['item_name' => 'name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'item_name' => 'Item Name',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[ItemName]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItemName(): \yii\db\ActiveQuery
    {
        return $this->hasOne(AuthItem::class, ['name' => 'item_name']);
    }

    /**
     * @param int $userId
     * @return array
     */
    public static function getRulesByUser(int $userId): array
    {
        return self::find()->where(['user_id' => $userId])->select(['item_name'])->all();
    }

    /**
     * @param int $userId
     * @return array
     */
    public static function getUserRulesToKartik(int $userId): array
    {
        $formattedRules = [];
        $userRules = self::find()->where(['user_id' => $userId])->select(['item_name'])->asArray()->column();
        $userRules = AuthItem::find()->where(['name' => $userRules])->all();

        /** @var AuthItem $rule */
        foreach ($userRules as $rule) {
            $formattedRules[$rule->name] = ['content' => '<i class="fas fa-cog"></i>' . $rule->description];
        }

        return $formattedRules;
    }

    /**
     * @return array
     */
    public static function getRulesListToKartik(): array
    {
        $Rules = [];
        $userRules = AuthItem::find()->where(['type' => 1])->all();

        /** @var AuthItem $rule */
        foreach ($userRules as $rule) {
            $Rules[$rule->name] = ['content' => '<i class="fas fa-cog"></i>' . $rule->description];
        }

        return $Rules;
    }
}
