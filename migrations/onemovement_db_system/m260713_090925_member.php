<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_090925_member extends Migration
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
            '{{%member}}',
            [
                'id'=> $this->primaryKey(11),
                'status'=> "enum('ACTIVE', 'INACTIVE') NULL DEFAULT 'ACTIVE'",
                'applicant_id'=> $this->integer(11)->notNull(),
                'alliance_id'=> $this->integer(11)->null()->defaultValue(null),
                'created_at'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%member}}');
    }
}
