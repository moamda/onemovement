<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_094549_auth_itemDataInsert extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $this->batchInsert('{{%auth_item}}',
                           ["name", "type", "description", "rule_name", "data", "created_at", "updated_at"],
                            [
    [
        'name' => 'access admin module',
        'type' => 2,
        'description' => null,
        'rule_name' => null,
        'data' => null,
        'created_at' => 1733724681,
        'updated_at' => 1733724681,
    ],
    [
        'name' => 'access alliance group',
        'type' => 2,
        'description' => null,
        'rule_name' => null,
        'data' => null,
        'created_at' => 1783554549,
        'updated_at' => 1783554549,
    ],
    [
        'name' => 'access applicants',
        'type' => 2,
        'description' => null,
        'rule_name' => null,
        'data' => null,
        'created_at' => 1783554525,
        'updated_at' => 1783554525,
    ],
    [
        'name' => 'access omi activities',
        'type' => 2,
        'description' => null,
        'rule_name' => null,
        'data' => null,
        'created_at' => 1783865200,
        'updated_at' => 1783865200,
    ],
    [
        'name' => 'access omi members',
        'type' => 2,
        'description' => null,
        'rule_name' => null,
        'data' => null,
        'created_at' => 1783554626,
        'updated_at' => 1783865160,
    ],
    [
        'name' => 'access rbac module',
        'type' => 2,
        'description' => null,
        'rule_name' => null,
        'data' => null,
        'created_at' => 1783867289,
        'updated_at' => 1783868107,
    ],
    [
        'name' => 'admin',
        'type' => 1,
        'description' => null,
        'rule_name' => null,
        'data' => null,
        'created_at' => 1727960373,
        'updated_at' => 1731224858,
    ],
    [
        'name' => 'super-admin',
        'type' => 1,
        'description' => null,
        'rule_name' => null,
        'data' => null,
        'created_at' => 1783866031,
        'updated_at' => 1783866031,
    ],
    [
        'name' => 'validator',
        'type' => 1,
        'description' => null,
        'rule_name' => null,
        'data' => null,
        'created_at' => 1783554446,
        'updated_at' => 1783554446,
    ],
]
        );
    }

    public function safeDown()
    {
        //$this->truncateTable('{{%auth_item}} CASCADE');
    }
}
