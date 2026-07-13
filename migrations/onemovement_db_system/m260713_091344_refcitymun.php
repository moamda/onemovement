<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_091344_refcitymun extends Migration
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
            '{{%refcitymun}}',
            [
                'id'=> $this->primaryKey(255),
                'psgcCode'=> $this->string(255)->null()->defaultValue(null),
                'citymunDesc'=> $this->text()->null()->defaultValue(null),
                'regDesc'=> $this->string(255)->null()->defaultValue(null),
                'provCode'=> $this->string(255)->null()->defaultValue(null),
                'citymunCode'=> $this->string(255)->null()->defaultValue(null),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%refcitymun}}');
    }
}
