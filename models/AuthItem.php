<?php

namespace app\models;

use app\classes\AdminMenu;
use Yii;
use yii\base\InvalidConfigException;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property int $type
 * @property string|null $description
 * @property string|null $rule_name
 * @property resource|null $data
 * @property string|null $rules
 * @property string|null $admin_tiles
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 * @property AuthItem[] $children
 * @property AuthItem[] $parents
 * @property AuthRule $ruleName
 */
class AuthItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data', 'admin_tiles', 'rules'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            [['name'], 'unique'],
            [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRule::class, 'targetAttribute' => ['rule_name' => 'name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'type' => 'Type',
            'description' => 'Description',
            'rule_name' => 'Rule Name',
            'data' => 'Data',
            'rules' => 'Правила роли',
            'admin_tiles' => 'Доступные поля в меню админа',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[AuthAssignments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments(): \yii\db\ActiveQuery
    {
        return $this->hasMany(AuthAssignment::class, ['item_name' => 'name']);
    }

    /**
     * Gets query for [[AuthItemChildren]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren(): \yii\db\ActiveQuery
    {
        return $this->hasMany(AuthItemChild::class, ['parent' => 'name']);
    }

    /**
     * Gets query for [[AuthItemChildren0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren0(): \yii\db\ActiveQuery
    {
        return $this->hasMany(AuthItemChild::class, ['child' => 'name']);
    }

    /**
     * Gets query for [[Children]].
     *
     * @return \yii\db\ActiveQuery
     *
     * @throws InvalidConfigException
     */
    public function getChildren()
    {
        return $this->hasMany(AuthItem::class, ['name' => 'child'])->viaTable('auth_item_child', ['parent' => 'name']);
    }

    /**
     * Gets query for [[Parents]].
     *
     * @return \yii\db\ActiveQuery
     *
     * @throws InvalidConfigException
     */
    public function getParents(): \yii\db\ActiveQuery
    {
        return $this->hasMany(AuthItem::class, ['name' => 'parent'])->viaTable('auth_item_child', ['child' => 'name']);
    }

    /**
     * Gets query for [[RuleName]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName(): \yii\db\ActiveQuery
    {
        return $this->hasOne(AuthRule::class, ['name' => 'rule_name']);
    }

    /**
     * @return array
     */
    public static function getAdminTilesKartikList(): array
    {
        $list = [];

        $tiles = AdminMenu::ADMIN_TILES;
        foreach ($tiles as $tileName => $tile) {
            $list[$tileName] = ['content' => str_replace('fa-4x', '', $tile['icon']) . $tile['title']];
        }

        return $list;
    }

    /**
     * @return array
     */
    public function getAuthItemAdminTilesKartikList(): array
    {
        $list = [];

        if (!empty($this->admin_tiles)) {
            if (is_string($this->admin_tiles)) {
                $this->admin_tiles = json_decode($this->admin_tiles);
            }
            foreach ($this->admin_tiles as $tileName) {
                if (array_key_exists($tileName, AdminMenu::ADMIN_TILES)) {
                    $tile = AdminMenu::ADMIN_TILES[$tileName];
                    $list[$tileName] = ['content' => str_replace('fa-4x', '', $tile['icon']) . $tile['title']];
                }
            }
        }

        return $list;
    }

    public static function getByRolesNames(array $rolesNames): array
    {
        return self::find()->where(['name' => $rolesNames])->all();
    }
}
