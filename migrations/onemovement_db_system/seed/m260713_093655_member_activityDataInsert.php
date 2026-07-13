<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_093655_member_activityDataInsert extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $this->batchInsert('{{%member_activity}}',
                           ["id", "member_id", "activity_id"],
                            [
    [
        'id' => 1,
        'member_id' => 1,
        'activity_id' => 2,
    ],
    [
        'id' => 2,
        'member_id' => 1,
        'activity_id' => 1,
    ],
]
        );
    }

    public function safeDown()
    {
        //$this->truncateTable('{{%member_activity}} CASCADE');
    }
}
