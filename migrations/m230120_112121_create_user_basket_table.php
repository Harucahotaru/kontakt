<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_basket}}`.
 */
class m230120_112121_create_user_basket_table extends Migration
{
    const USER_BASKET_TABLE = '{{%user_basket}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::USER_BASKET_TABLE, [
            'id' => $this->primaryKey()->comment('Id'),
            'user_id' => $this->integer()->notNull()->comment('Id пользователя'),
            'products_ids' => $this->json()->notNull()->comment('Id товаров'),
            'date_c' => $this->dateTime()->comment('Дата создания'),
            'date_m' => $this->dateTime()->comment('Дата изменения'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::USER_BASKET_TABLE);
    }
}
