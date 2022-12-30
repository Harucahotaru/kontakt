<?php

use yii\db\Migration;

/**
 * Class m221221_094749_change_products_parent_id_type
 */
class m221221_094749_change_products_parent_id_type extends Migration
{
    const PRODUCT_TABLE = '{{%products}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(self::PRODUCT_TABLE, 'parent_id', $this->json());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn(self::PRODUCT_TABLE, 'parent_id', $this->string(255));
    }
}
