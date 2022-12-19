<?php

use yii\db\Migration;

/**
 * Class m221216_093517_add_product_img_table
 */
class m221216_093517_add_product_img_table extends Migration
{
    const PRODUCT_IMAGES_TABLE = '{{%products_imgs}}';

    /**
     * @throws \yii\base\Exception
     */
    public function safeUp()
    {
        $this->createTable(self::PRODUCT_IMAGES_TABLE, [
            'id' => $this->primaryKey(),
            'main_img_id' => $this->integer()->comment('Id главного изоображения'),
            'imgs_ids' => $this->json()->comment('Id изображений'),
        ]);
        $this->createIndex('product_images_id_index', self::PRODUCT_IMAGES_TABLE, [
            'id',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::PRODUCT_IMAGES_TABLE);
    }
}
