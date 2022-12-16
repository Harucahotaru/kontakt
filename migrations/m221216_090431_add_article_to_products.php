<?php

use yii\db\Migration;

/**
 * Class m221216_090431_add_article_to_products
 */
class m221216_090431_add_article_to_products extends Migration
{
    const PRODUCT_TABLE = '{{%products}}';

    public function safeUp()
    {
        $this->addColumn(self::PRODUCT_TABLE, 'article', $this->string(50)->comment('Артикул'));
    }

    public function safeDown()
    {
        $this->dropColumn(self::PRODUCT_TABLE, 'article');
    }

}
