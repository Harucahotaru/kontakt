<?php

use yii\db\Migration;

/**
 * Class m220803_114139_images_table
 */
class m220803_114139_images_table extends Migration
{
    const IMAGES_TABLE = '{{%images}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::IMAGES_TABLE, [
            'id' => $this->primaryKey()->comment('Id'),
            'project_path' => $this->string()->notNull()->unique()->comment('Путь'),
            'size' => $this->integer()->comment('Размер'),
            'description' => $this->string()->comment('Описание'),
            'date_c' => $this->dateTime()->comment('Дата создания'),
            'hash' => $this->string()->unique()->notNull()->comment('Хэш'),
            'name' => $this->varchar(255)->notNull()->comment('имя изображения'),
        ]);
        $this->addCommentOnTable(self::IMAGES_TABLE, 'Таблица изображений');
        $this->createIndex('image_hash_index', self::IMAGES_TABLE, [
            'hash',
        ],true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::IMAGES_TABLE);

        return true;
    }
}