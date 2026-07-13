<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_094529_auth_assignmentDataInsert extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $this->batchInsert('{{%auth_assignment}}',
                           ["item_name", "user_id", "created_at"],
                            [
    [
        'item_name' => 'access admin module',
        'user_id' => '1',
        'created_at' => 1734337900,
    ],
    [
        'item_name' => 'access alliance group',
        'user_id' => '1',
        'created_at' => 1783866460,
    ],
    [
        'item_name' => 'access applicants',
        'user_id' => '1',
        'created_at' => 1783866460,
    ],
    [
        'item_name' => 'access applicants',
        'user_id' => '8',
        'created_at' => 1783868571,
    ],
    [
        'item_name' => 'access omi activities',
        'user_id' => '1',
        'created_at' => 1783866460,
    ],
    [
        'item_name' => 'access omi members',
        'user_id' => '1',
        'created_at' => 1783866460,
    ],
    [
        'item_name' => 'access omi members',
        'user_id' => '8',
        'created_at' => 1783868571,
    ],
    [
        'item_name' => 'access rbac module',
        'user_id' => '7',
        'created_at' => 1783867564,
    ],
    [
        'item_name' => 'admin',
        'user_id' => '1',
        'created_at' => 1732004147,
    ],
    [
        'item_name' => 'super-admin',
        'user_id' => '7',
        'created_at' => 1783866202,
    ],
    [
        'item_name' => 'validator',
        'user_id' => '1',
        'created_at' => 1783866456,
    ],
    [
        'item_name' => 'validator',
        'user_id' => '8',
        'created_at' => 1783868571,
    ],
]
        );
    }

    public function safeDown()
    {
        //$this->truncateTable('{{%auth_assignment}} CASCADE');
    }
}
