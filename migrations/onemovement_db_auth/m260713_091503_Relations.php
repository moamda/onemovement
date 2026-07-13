<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_091503_Relations extends Migration
{

    public function init()
    {
       $this->db = 'onemovement_db_auth';
       parent::init();
    }

    public function safeUp()
    {
        $this->addForeignKey('fk_auth_assignment_item_name',
            '{{%auth_assignment}}','item_name',
            '{{%auth_item}}','name',
            'CASCADE','CASCADE'
         );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_auth_assignment_item_name', '{{%auth_assignment}}');
    }
}
