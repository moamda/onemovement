<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_091502_auth_assignment extends Migration
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
            '{{%auth_assignment}}',
            [
                'item_name'=> $this->string(64)->notNull(),
                'user_id'=> $this->string(64)->notNull(),
                'created_at'=> $this->integer(11)->null()->defaultValue(null),
            ],$tableOptions
        );
        $this->createIndex('idx-auth_assignment-user_id','{{%auth_assignment}}',['user_id'],false);
        $this->addPrimaryKey('pk_on_auth_assignment','{{%auth_assignment}}',['item_name','user_id']);

    }

    public function safeDown()
    {
    $this->dropPrimaryKey('pk_on_auth_assignment','{{%auth_assignment}}');
        $this->dropIndex('idx-auth_assignment-user_id', '{{%auth_assignment}}');
        $this->dropTable('{{%auth_assignment}}');
    }
}
