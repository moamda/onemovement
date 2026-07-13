<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_092139_user extends Migration
{

    public function init()
    {
        $this->db = 'onemovement_db_user';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%user}}',
            [
                'id'=> $this->primaryKey(11),
                'username'=> $this->string(300)->notNull(),
                'auth_key'=> $this->string(300)->notNull(),
                'password_hash'=> $this->string(300)->notNull(),
                'password_reset_token'=> $this->string(300)->null()->defaultValue(null),
                'verification_token'=> $this->string(255)->notNull(),
                'email'=> $this->string(300)->notNull(),
                'status'=> $this->integer(11)->notNull()->defaultValue(10),
                'created_at'=> $this->integer(11)->notNull(),
                'updated_at'=> $this->integer(11)->notNull(),
                'code_name'=> $this->string(300)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
