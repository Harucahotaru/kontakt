<?php

use yii\db\Migration;

/**
 * Class m220803_104109_news_categories_create
 */
class m220803_104109_news_categories_create extends Migration
{
    const CATEGORY_TABLE = '{{%category_news}}';
    const IS_ACTIVE = true;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::CATEGORY_TABLE, [
            'id' => $this->primaryKey()->comment('id'),
            'name' => $this->string()->notNull()->comment('Название'),
            'url_name' => $this->string()->notNull()->comment('url'),
            'description' => $this->text()->comment('Описание'),
            'parent_id' => $this->integer()->defaultValue(null)->comment('id родительской категории'),
            'active' => $this->boolean()->notNull()->defaultValue(self::IS_ACTIVE)->comment('Активность'),
        ]);
        $this->addCommentOnTable(self::CATEGORY_TABLE, 'Таблица категорий новостей');
        $this->createIndex('cat_index', self::CATEGORY_TABLE, [
            'active',
            'parent_id',
        ]);
        $this->createIndex('uniq_index', self::CATEGORY_TABLE, [
            'url_name',
            'parent_id',
            'active',
        ], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::CATEGORY_TABLE);
        return true;
    }
}