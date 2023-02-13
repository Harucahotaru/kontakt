<?php

use yii\db\Migration;

/**
 * Class m230213_135648_add_rules_to_auth_item
 */
class m230213_135648_add_rules_to_auth_item extends Migration
{
    const TABLE_NAME = '{{%auth_item}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE_NAME, 'rules', $this->json()->comment('Правила для роли'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE_NAME, 'rules');
    }
}