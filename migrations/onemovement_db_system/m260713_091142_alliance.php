<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_091142_alliance extends Migration
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
            '{{%alliance}}',
            [
                'id'=> $this->primaryKey(11),
                'status'=> "enum('active', 'inactive') NOT NULL DEFAULT 'active'",
                'organization'=> $this->string(255)->null()->defaultValue(null),
                'area_of_ceverage'=> $this->string(255)->null()->defaultValue(null),
                'estimated_members'=> $this->integer(11)->null()->defaultValue(null),
                'alliance_leader_user_id'=> $this->integer(11)->null()->defaultValue(null),
                'alliance_leader_contact'=> $this->integer(11)->null()->defaultValue(null),
                'created_at'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
                'alliance_leader_position'=> "enum('President', 'Chapter President', 'Chairman', 'Vice President') NULL DEFAULT NULL",
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%alliance}}');
    }
}
