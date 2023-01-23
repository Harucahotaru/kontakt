<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reviews}}`.
 */
class m230109_134956_create_reviews_table extends Migration
{
    const PRODUCTS_REVIEWS_TABLE = '{{%reviews}}';
    const STATUS_VISIBLE = 1;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::PRODUCTS_REVIEWS_TABLE, [
            'id' => $this->primaryKey()->comment('Id отзыва'),
            'user_id' => $this->integer()->notNull()->comment('Id пользователя'),
            'entity_id' => $this->integer()->notNull()->comment('Id сущности'),
            'type' => $this->integer()->notNull()->comment('Тип сущности'),
            'experience' => $this->text()->comment('Опыт'),
            'benefits' => $this->text()->comment('Преимущества'),
            'limitations' => $this->text()->comment('Недостатки'),
            'content' => $this->text()->comment('Содержание'),
            'rate' => $this->integer()->comment('Оценка'),
            'visible' => $this->integer()->defaultValue(self::STATUS_VISIBLE)->comment('Видимость'),
            'date_c' => $this->dateTime()->comment('Дата создания'),
            'date_m' => $this->dateTime()->comment('Дата изменения'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::PRODUCTS_REVIEWS_TABLE);
    }
}
