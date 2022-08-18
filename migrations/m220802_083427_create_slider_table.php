<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%slider}}`.
 */
class m220802_083427_create_slider_table extends Migration
{
    const ACTIVE_SLIDE = 1;
    const DISABLE_SLIDE = 0;
    const TABLE_NAME = 'slider';

    public function up()
    {
        $tableOptions = null;

        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey()->comment('id слайда'),
            'img_id' => $this->integer()->comment('id изображеия'),
            'type' => $this->string(30)->notNull()->comment(''),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(self::ACTIVE_SLIDE)->comment('активен слайд, или нет '),
            'content_options' =>$this->string(50)->comment('параметры для контента'),
            'content' =>$this->string(250)->comment('контент для сладйа'),
            'added_date'=>$this->dateTime()->comment('Дата добавления')
        ], $tableOptions);
        $this->createIndex('slider_index', self::TABLE_NAME, [
            'type',
            'status',
        ]);
    }

    public function down()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
