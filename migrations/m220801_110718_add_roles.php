<?php

use yii\db\Migration;
use yii\db\Query;
use yii\rbac\Item;

/**
 * Class m220528_071255_add_roles
 */
class m220801_110718_add_roles extends Migration
{
    public $roles = '{{%auth_item}}';
    public $roles_child = '{{%auth_item_child}}';
    public $auth_assign = '{{%auth_assignment}}';
    public $user = '{{%user}}';
    public $adminMailList = [
        'alissian.2002@gmail.com',
        'alissian.1993@gmail.com',
        'yayug_@mail.ru',
    ];
    public $role_admin = 'admin';
    public $role_moderator = 'moderator';
    public $create_role = 'create_role';
    public $update_role = 'update_role';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->delete($this->roles);
        $this->delete($this->roles_child);
        $this->delete($this->auth_assign);
        $this->insert($this->roles, [
            'name' => $this->role_admin,
            'type' => Item::TYPE_ROLE,
            'description' => 'Роль админа',
            'created_at' => Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')),
            'updated_at' => Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')),
        ]);
        $this->insert($this->roles, [
            'name' => $this->create_role,
            'type' => Item::TYPE_PERMISSION,
            'description' => 'Создание роли',
            'created_at' => Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')),
            'updated_at' => Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')),
        ]);
        $this->insert($this->roles, [
            'name' => $this->role_moderator,
            'type' => Item::TYPE_ROLE,
            'description' => 'Моредатор',
            'created_at' => Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')),
            'updated_at' => Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')),
        ]);
        $this->insert($this->roles, [
            'name' => $this->update_role,
            'type' => Item::TYPE_PERMISSION,
            'description' => 'Обновление роли',
            'created_at' => Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')),
            'updated_at' => Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s')),
        ]);
        $this->insert($this->roles_child, [
            'parent' => $this->role_moderator,
            'child' => $this->create_role,
        ]);
        $this->insert($this->roles_child, [
            'parent' => $this->role_admin,
            'child' => $this->role_moderator,
        ]);
        $this->insert($this->roles_child, [
            'parent' => $this->role_admin,
            'child' => $this->create_role,
        ]);
        $userIds = (new Query())
            ->select('id')
            ->from($this->user)
            ->where(['email' => $this->adminMailList])
            ->all();
        foreach ($userIds as $userId) {
            $this->insert($this->auth_assign, [
                'item_name' => $this->role_admin,
                'user_id' => $userId['id'],
                'created_at' =>Yii::$app->formatter->asTimestamp(date('Y-d-m h:i:s'))
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete($this->roles);
        $this->delete($this->auth_assign);
        $this->delete($this->roles_child);
        echo "m220528_071255_add_roles good.\n";
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220528_071255_add_roles cannot be reverted.\n";

        return false;
    }
    */
}
