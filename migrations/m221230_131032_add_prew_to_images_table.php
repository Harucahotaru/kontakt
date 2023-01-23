<?php

use yii\db\Migration;

/**
 * Class m221230_131032_add_prew_to_images_table
 */
class m221230_131032_add_prew_to_images_table extends Migration
{
    const IMAGES_TABLE = '{{%images}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::IMAGES_TABLE, 'prew_path', $this->json()->comment('Путь к превью'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::IMAGES_TABLE, 'prew_path');
    }
}
