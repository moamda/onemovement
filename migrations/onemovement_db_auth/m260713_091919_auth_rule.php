<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_091919_auth_rule extends Migration
{

    public function init()
    {
        $this->db = 'onemovement_db_auth';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%auth_rule}}',
            [
                'name'=> $this->string(64)->notNull(),
                'data'=> $this->binary()->null()->defaultValue(null),
                'created_at'=> $this->integer(11)->null()->defaultValue(null),
                'updated_at'=> $this->integer(11)->null()->defaultValue(null),
            ],$tableOptions
        );
        $this->addPrimaryKey('pk_on_auth_rule','{{%auth_rule}}',['name']);

    }

    public function safeDown()
    {
    $this->dropPrimaryKey('pk_on_auth_rule','{{%auth_rule}}');
        $this->dropTable('{{%auth_rule}}');
    }
}
