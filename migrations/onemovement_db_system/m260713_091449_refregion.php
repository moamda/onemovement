<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_091449_refregion extends Migration
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
            '{{%refregion}}',
            [
                'id'=> $this->primaryKey(11),
                'psgcCode'=> $this->string(255)->null()->defaultValue(null),
                'regDesc'=> $this->text()->null()->defaultValue(null),
                'regCode'=> $this->string(255)->null()->defaultValue(null),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%refregion}}');
    }
}
