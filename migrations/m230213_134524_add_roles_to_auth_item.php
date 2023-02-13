<?php

use yii\db\Migration;

/**
 * Class m230213_134524_add_roles_to_auth_item
 */
class m230213_134524_add_roles_to_auth_item extends Migration
{
    const TABLE_NAME = '{{%auth_item}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert(self::TABLE_NAME, [
            'name' => 'base_user',
            'type' => '1',
            'description' => 'Базовая роль зарегистрированного пользователя',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete(self::TABLE_NAME, ['name' => 'base_user']);
    }
}
