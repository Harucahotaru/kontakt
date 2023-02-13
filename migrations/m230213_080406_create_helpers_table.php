<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%helpers}}`.
 */
class m230213_080406_create_helpers_table extends Migration
{
    const TABLE_NAME = '{{%helpers}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey()->comment('Id'),
            'label' => $this->string()->comment('Название подсказки'),
            'content' => $this->text()->comment('Содержание подсказки'),
            'url' => $this->string()->comment('Адрес подсказки'),
            'type' => $this->integer()->defaultValue(1)->comment('Тип подсказки'),
            'item' => $this->string()->defaultValue('main')->comment('Элемент подсказки'),
            'date_c' => $this->dateTime()->comment('Дата создания'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
