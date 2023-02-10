<?php

use yii\db\Migration;

/**
 * Class m230210_104433_change_sale_type_products
 */
class m230210_104433_change_sale_type_products extends Migration
{
    private const TABLE_NAME = '{{%products}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn(self::TABLE_NAME, 'sale', $this->decimal(19, 2)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn(self::TABLE_NAME, 'sale', $this->integer());
    }
}
