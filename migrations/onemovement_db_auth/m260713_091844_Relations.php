<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_091844_Relations extends Migration
{

    public function init()
    {
       $this->db = 'onemovement_db_auth';
       parent::init();
    }

    public function safeUp()
    {
        $this->addForeignKey('fk_auth_item_child_parent',
            '{{%auth_item_child}}','parent',
            '{{%auth_item}}','name',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_auth_item_child_child',
            '{{%auth_item_child}}','child',
            '{{%auth_item}}','name',
            'CASCADE','CASCADE'
         );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_auth_item_child_parent', '{{%auth_item_child}}');
        $this->dropForeignKey('fk_auth_item_child_child', '{{%auth_item_child}}');
    }
}
