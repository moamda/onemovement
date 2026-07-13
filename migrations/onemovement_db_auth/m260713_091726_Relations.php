<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_091726_Relations extends Migration
{

    public function init()
    {
       $this->db = 'onemovement_db_auth';
       parent::init();
    }

    public function safeUp()
    {
        $this->addForeignKey('fk_auth_item_rule_name',
            '{{%auth_item}}','rule_name',
            '{{%auth_rule}}','name',
            'CASCADE','CASCADE'
         );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_auth_item_rule_name', '{{%auth_item}}');
    }
}
