<?php

use yii\db\Migration;

/**
 * Class m220802_103229_add_rule_controller_user_logout
 */
class m220802_103229_add_rule_controller_user_logout extends Migration
{
    public $controller_rules_table = '{{%controller_rules}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert($this->controller_rules_table,[
            'controller_name' => 'site',
            'action' => 'logout',
            'role' => '@',
            'allow' => true,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete($this->controller_rules_table,[
            'controller_name' => 'site',
            'action' => 'logout',
            'role' => '@',
            'allow' => true,
        ]);

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220802_103229_add_rule_controller_user_logout cannot be reverted.\n";

        return false;
    }
    */
}
