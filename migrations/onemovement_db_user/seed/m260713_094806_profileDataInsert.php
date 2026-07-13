<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_094806_profileDataInsert extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $this->batchInsert('{{%profile}}',
                           ["id", "user_id", "last_name", "first_name", "middle_name", "suffix", "gender", "address", "contact"],
                            [
    [
        'id' => 1,
        'user_id' => 1,
        'last_name' => '-',
        'first_name' => '-',
        'middle_name' => '-',
        'suffix' => '-',
        'gender' => '-',
        'address' => '-',
        'contact' => '-',
    ],
    [
        'id' => 5,
        'user_id' => 7,
        'last_name' => '-',
        'first_name' => '-',
        'middle_name' => '-',
        'suffix' => '',
        'gender' => '-',
        'address' => '-',
        'contact' => '-',
    ],
    [
        'id' => 6,
        'user_id' => 8,
        'last_name' => 'mendoza',
        'first_name' => 'eman',
        'middle_name' => '',
        'suffix' => '',
        'gender' => 'Male',
        'address' => 'Magsaysay Ext. P2-A',
        'contact' => '123',
    ],
]
        );
    }

    public function safeDown()
    {
        //$this->truncateTable('{{%profile}} CASCADE');
    }
}
