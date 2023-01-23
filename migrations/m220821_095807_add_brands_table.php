<?php

use yii\db\Migration;

/**
 * Class m220821_095807_add_brands_table
 */
class m220821_095807_add_brands_table extends Migration
{
    const BRANDS_TABLE = '{{%brands}}';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::BRANDS_TABLE, [
            'id'          => $this->primaryKey()->comment('Id'),
            'name'        => $this->string()->notNull()->unique()->comment('Имя'),
            'description' => $this->string()->comment('Описание'),
            'urlname'     => $this->string()->notNull()->comment('Адрес'),
            'date_c'      => $this->dateTime()->comment('Дата создания'),
            'user_c'      => $this->dateTime()->comment('Дата создания'),
            'img_id'      => $this->integer()->comment('ID изображения'),
        ]);
        $this->addCommentOnTable(self::BRANDS_TABLE, 'Таблица брендов');
        $this->createIndex('image_hash_index', self::BRANDS_TABLE, [
            'urlname',
        ], true);
    }
    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::BRANDS_TABLE);
        echo "m220821_095807_add_brands_table cannot be reverted.\n";
        
        return true;
    }
}
