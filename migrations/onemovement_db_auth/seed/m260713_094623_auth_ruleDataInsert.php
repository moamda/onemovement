<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_094623_auth_ruleDataInsert extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $this->batchInsert('{{%auth_rule}}',
                           ["name", "data", "created_at", "updated_at"],
                            [
    [
        'name' => '',
        'data' => '',
        'created_at' => '',
        'updated_at' => '',
    ],
]
        );
    }

    public function safeDown()
    {
        //$this->truncateTable('{{%auth_rule}} CASCADE');
    }
}
