<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_092039_profile extends Migration
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
            '{{%profile}}',
            [
                'id'=> $this->primaryKey(11),
                'user_id'=> $this->integer(11)->notNull(),
                'last_name'=> $this->string(100)->notNull(),
                'first_name'=> $this->string(100)->notNull(),
                'middle_name'=> $this->string(100)->notNull(),
                'suffix'=> $this->string(10)->notNull(),
                'gender'=> $this->string(100)->notNull(),
                'address'=> $this->string(100)->notNull(),
                'contact'=> $this->string(100)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%profile}}');
    }
}
