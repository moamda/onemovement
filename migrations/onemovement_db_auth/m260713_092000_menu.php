<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_092000_menu extends Migration
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
            '{{%menu}}',
            [
                'id'=> $this->primaryKey(11),
                'name'=> $this->string(128)->notNull(),
                'parent'=> $this->integer(11)->null()->defaultValue(null),
                'route'=> $this->string(255)->null()->defaultValue(null),
                'order'=> $this->integer(11)->null()->defaultValue(null),
                'data'=> $this->binary()->null()->defaultValue(null),
            ],$tableOptions
        );
        $this->createIndex('parent','{{%menu}}',['parent'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('parent', '{{%menu}}');
        $this->dropTable('{{%menu}}');
    }
}
