<?php

use yii\db\Migration;

/**
 * Class m221129_110232_add_PAGES_CONTENT_content
 */
class m221129_110232_add_pages_content extends Migration
{
    private const PAGES_CONTENT = 'pages_content';

    public function safeUp()
    {
        $this->createTable(self::PAGES_CONTENT, [
            'id' => $this->primaryKey(),
            'page_id' => $this->string()->notNull(),
            'content' => $this->text(),
            'active' => $this->boolean()->defaultValue(true),
        ]);
        $this->createIndex('image_sale_index', self::PAGES_CONTENT, [
            'active',
            'name',
        ]);
        $this->createIndex('image_sale_index', self::PAGES_CONTENT, [
            'active',
            'page_id',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::PAGES_CONTENT);

        return true;
    }
}
