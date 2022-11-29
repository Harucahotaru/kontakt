<?php

use yii\db\Migration;

/**
 * Class m221129_105828_add_pages
 */
class m221129_105828_add_pages extends Migration
{
    private const PAGES = 'pages';

    public function safeUp()
    {
        $this->createTable(self::PAGES, [
            'id' => $this->primaryKey(),
            'url' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'active' => $this->boolean()->defaultValue(true),
        ]);
        $this->createIndex('image_category_id_index', self::PAGES, [
            'active',
            'url',
        ]);
        $this->createIndex('image_sale_index', self::PAGES, [
            'active',
            'name',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::PAGES);

        return true;
    }
}
