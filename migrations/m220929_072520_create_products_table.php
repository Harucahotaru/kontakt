<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 */
class m220929_072520_create_products_table extends Migration
{
    const PRODUCT_TABLE = '{{%products}}';
    const IS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::PRODUCT_TABLE, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('наименование товара'),
            'description' => $this->string()->comment('описание товара'),
            'cost' => $this->integer()->notNull()->comment('цена товара'),
            'on_sale' => $this->integer()->notNull()->defaultValue(self::IS_ACTIVE)->comment('статус скидки'),
            'sale' => $this->integer()->comment('размер скиидки на товар'),
            'img_id' => $this->integer()->comment('id изображения'),
            'category_id' => $this->string()->comment('id категории'),
            'parent_id' => $this->string()->comment('id подходящих товаров'),
            'date_c' => $this->dateTime()->comment('Дата создания'),
            'date_m' => $this->dateTime()->comment('Дата изменения'),
            'active' => $this->boolean()->notNull()->defaultValue(self::IS_ACTIVE)->comment('Активность'),
        ]);
        $this->createIndex('image_category_id_index', self::PRODUCT_TABLE, [
            'active',
            'category_id',
        ]);
        $this->createIndex('image_sale_index', self::PRODUCT_TABLE, [
            'active',
            'on_sale',
        ]);
        $this->createIndex('image_parent_product_index', self::PRODUCT_TABLE, [
            'active',
            'id',
        ], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::PRODUCT_TABLE);
    }
}
