<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%%products_categories}}`.
 */
class m221222_083101_create_products_categories_table extends Migration
{
    const CATEGORIES_TABLE = '{{%products_categories}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::CATEGORIES_TABLE, [
            'id' => $this->primaryKey()->comment('Id категории'),
            'name' => $this->string()->notNull()->comment('Название категории'),
            'url_name' => $this->string()->notNull()->comment('Название для адресной строки'),
            'is_main_category' => $this->boolean()->comment('Является ли категория главной'),
            'parent_id' => $this->integer()->comment('Связанная категория'),
            'icon' => $this->string()->comment('Картинка для меню'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::CATEGORIES_TABLE);
    }
}
