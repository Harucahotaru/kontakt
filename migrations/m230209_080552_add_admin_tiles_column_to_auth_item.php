<?php

use yii\db\Migration;

/**
 * Class m230209_080552_add_admin_tiles_column_to_auth_item
 */
class m230209_080552_add_admin_tiles_column_to_auth_item extends Migration
{
    const AUTH_ITEM_TABLE = '{{%auth_item}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::AUTH_ITEM_TABLE, 'admin_tiles', $this->json()->comment('Доступные поля в меню админа'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::AUTH_ITEM_TABLE, 'admin_tiles');
    }
}
