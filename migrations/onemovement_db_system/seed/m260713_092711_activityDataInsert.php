<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_092711_activityDataInsert extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $this->batchInsert('{{%activity}}',
                           ["id", "activity_name"],
                            [
    [
        'id' => 1,
        'activity_name' => 'Tree Planting Phase 1',
    ],
    [
        'id' => 2,
        'activity_name' => 'Tree Planting Phase 2',
    ],
]
        );
    }

    public function safeDown()
    {
        //$this->truncateTable('{{%activity}} CASCADE');
    }
}
