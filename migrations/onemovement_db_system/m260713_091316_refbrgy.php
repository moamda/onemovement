<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_091316_refbrgy extends Migration
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
            '{{%refbrgy}}',
            [
                'id'=> $this->primaryKey(11),
                'brgyCode'=> $this->string(255)->null()->defaultValue(null),
                'brgyDesc'=> $this->text()->null()->defaultValue(null),
                'regCode'=> $this->string(255)->null()->defaultValue(null),
                'provCode'=> $this->string(255)->null()->defaultValue(null),
                'citymunCode'=> $this->string(255)->null()->defaultValue(null),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%refbrgy}}');
    }
}
