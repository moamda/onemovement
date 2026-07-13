<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_094609_auth_item_childDataInsert extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $this->batchInsert('{{%auth_item_child}}',
                           ["parent", "child"],
                            [
    [
        'parent' => 'admin',
        'child' => 'access admin module',
    ],
]
        );
    }

    public function safeDown()
    {
        //$this->truncateTable('{{%auth_item_child}} CASCADE');
    }
}
