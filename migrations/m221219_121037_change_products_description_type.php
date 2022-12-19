<?php

use yii\db\Migration;

/**
 * Class m221219_121037_change_products_desctription_type
 */
class m221219_121037_change_products_description_type extends Migration
{
    const PRODUCT_TABLE = '{{%products}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(self::PRODUCT_TABLE, 'description', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn(self::PRODUCT_TABLE, 'description', $this->string());
    }
}
