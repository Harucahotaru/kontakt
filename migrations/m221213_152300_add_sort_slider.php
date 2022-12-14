<?php

use yii\db\Migration;

/**
 * Class m221213_152300_add_sort_slider
 */
class m221213_152300_add_sort_slider extends Migration
{
    private const SLIDER = 'slider';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::SLIDER,'sort',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::SLIDER,'sort');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221213_152300_add_sort_slider cannot be reverted.\n";

        return false;
    }
    */
}
