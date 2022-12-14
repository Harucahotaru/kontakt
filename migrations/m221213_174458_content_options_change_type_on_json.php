<?php

use yii\db\Migration;

/**
 * Class m221213_152300_add_sort_slider
 */
class m221213_174458_content_options_change_type_on_json extends Migration
{
    private const SLIDER = 'slider';
    private const COLUMN = 'content_options';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update(self::SLIDER, [self::COLUMN => null]);
        $this->alterColumn(self::SLIDER,self::COLUMN,$this->json());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->update(self::SLIDER, [self::COLUMN => null]);
        $this->alterColumn(self::SLIDER,self::COLUMN,$this->string(50));

        return true;
    }

}
