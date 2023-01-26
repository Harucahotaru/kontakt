<?php

use yii\db\Migration;

/**
 * Class m230126_071648_change_currency_type
 */
class m230126_071648_change_currency_type extends Migration
{
    private const TABLE_NAME = '{{%products}}';
    private const OLD_COLUMN = 'cost';
    private const NEW_COLUMN = 'currency';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn(self::TABLE_NAME, self::OLD_COLUMN, self::NEW_COLUMN);
        $this->alterColumn(self::TABLE_NAME, self::NEW_COLUMN, $this->decimal(19,2)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn(self::TABLE_NAME, self::NEW_COLUMN, self::OLD_COLUMN);
        $this->alterColumn(self::TABLE_NAME, self::OLD_COLUMN, $this->integer());

        return true;
    }
}
