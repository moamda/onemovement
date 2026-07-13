<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_091240_member_activity extends Migration
{

    public function init()
    {
        $this->db = 'onemovement_db_system';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%member_activity}}',
            [
                'id'=> $this->primaryKey(11),
                'member_id'=> $this->integer(11)->notNull(),
                'activity_id'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%member_activity}}');
    }
}
