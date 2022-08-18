<?php

use yii\db\Migration;

/**
 * Class m220803_112319_news_table
 */
class m220803_112319_news_table extends Migration
{
    const NEWS_TABLE = '{{%news}}';
    const IS_ACTIVE = true;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::NEWS_TABLE, [
            'id' => $this->primaryKey()->comment('Id'),
            'name' => $this->string()->notNull()->comment('Название'),
            'url_name' => $this->string()->notNull()->unique()->comment('Url'),
            'content' => $this->text()->notNull()->comment('Контент'),
            'description' => $this->text()->comment('Описание'),
            'category_id' => $this->integer()->defaultValue(null)->comment('id категории'),
            'date_c' => $this->dateTime()->comment('Дата создания'),
            'date_m' => $this->dateTime()->comment('Дата изменения'),
            'c_author_id' => $this->integer()->comment('Id создавшего автора'),
            'u_author_id' => $this->integer()->comment('Id обновившего автора'),
            'active' => $this->boolean()->notNull()->defaultValue(self::IS_ACTIVE)->comment('Активность'),
            'params' => $this->json()->comment('Параметры'),
        ]);
        $this->addCommentOnTable(self::NEWS_TABLE, 'Таблица новостей');
        $this->createIndex('news_url_index', self::NEWS_TABLE, [
            'url_name',
            'active',
        ]);
        $this->createIndex('news_category_index', self::NEWS_TABLE, [
            'category_id',
        ]);
        $this->createIndex('news_index', self::NEWS_TABLE, [
            'name',
            'active',
        ]);
        $this->createIndex('news_author_index', self::NEWS_TABLE, [
            'c_author_id',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::NEWS_TABLE);

        return true;
    }
}