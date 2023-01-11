<?php

use yii\db\Migration;

/**
 * Class m230111_093026_set_products_cost_optional
 */
class m230111_093026_set_products_cost_optional extends Migration
{
    const PRODUCT_TABLE = '{{%products}}';

    public function safeUp()
    {
        $this->alterColumn(self::PRODUCT_TABLE, 'cost', $this->integer()->comment('цена'));
    }

    public function safeDown()
    {
        $this->alterColumn(self::PRODUCT_TABLE, 'cost', $this->integer()->notNull()->comment('цена'));
    }
}
