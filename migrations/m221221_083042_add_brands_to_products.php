<?php

use yii\db\Migration;

/**
 * Class m221221_083042_add_brands_to_products
 */
class m221221_083042_add_brands_to_products extends Migration
{
    const PRODUCT_TABLE = '{{%products}}';

    public function safeUp()
    {
        $this->addColumn(self::PRODUCT_TABLE, 'brand_id', $this->integer()->comment('Id бренда'));
    }

    public function safeDown()
    {
        $this->dropColumn(self::PRODUCT_TABLE, 'brand_id');
    }
}
