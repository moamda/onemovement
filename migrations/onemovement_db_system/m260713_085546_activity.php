<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_085546_activity extends Migration
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
            '{{%activity}}',
            [
                'id'=> $this->primaryKey(11),
                'activity_name'=> $this->string(255)->null()->defaultValue(null),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%activity}}');
    }
}
