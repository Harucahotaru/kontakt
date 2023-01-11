<?php

use yii\db\Migration;

/**
 * Class m230110_131827_review_table_add_acepted
 */
class m230110_131827_review_table_add_acepted extends Migration
{
    const REVIEWS_TABLE = '{{%reviews}}';

    public function safeUp()
    {
        $this->addColumn(self::REVIEWS_TABLE, 'accepted', $this->boolean()->notNull()->comment('Подтверждение коммента'));
    }

    public function safeDown()
    {
        $this->dropColumn(self::REVIEWS_TABLE, 'accepted');
    }
}
