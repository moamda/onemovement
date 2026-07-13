<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_092001_Relations extends Migration
{

    public function init()
    {
       $this->db = 'onemovement_db_auth';
       parent::init();
    }

    public function safeUp()
    {
        $this->addForeignKey('fk_menu_parent',
            '{{%menu}}','parent',
            '{{%menu}}','id',
            'CASCADE','CASCADE'
         );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_menu_parent', '{{%menu}}');
    }
}
