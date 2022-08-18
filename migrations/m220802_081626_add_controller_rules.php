<?php

use yii\db\Migration;

/**
 * Class m220802_081626_add_controller_rules
 */
class m220802_081626_add_controller_rules extends Migration
{
    public $controller_rules_table = '{{%controller_rules}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->controller_rules_table, [
            'id' => $this->primaryKey()->comment('ID'),
            'controller_name' => $this->string(30)->notNull()->comment('Имя контроллера'),
            'action' => $this->string(30)->comment('Имя действия'),
            'role' => $this->string(30)->comment('id роли'),
            'allow' => $this->boolean()->defaultValue(true)->comment('Разрешить или запретить'),
            'user_creator' => $this->integer()->comment('ID пользователя создавшего правило'),
            'date_m' => $this->dateTime()->comment('Дата изменения')
        ]);
        $this->addCommentOnTable($this->controller_rules_table, 'Таблица с набором правил для контроллеров');
        $this->createIndex('unic_index',$this->controller_rules_table,[
            'controller_name',
            'action',
            'role',
            ],true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->controller_rules_table);

        return true;
    }
}
