<?php

namespace app\models;

use Yii;
use app\modules\admin\models\Profile;

/**
 * This is the model class for table "group_sectorial".
 *
 * @property int $id
 * @property string|null $group_name
 * @property string|null $group_description
 * @property int|null $group_leader_user_id
 * @property int|null $group_leader_contact
 * @property string $created_at
 */
class GroupSectorial extends \yii\db\ActiveRecord
{
    /**
     * ENUM field values
     */
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'group_sectorial';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('onemovement_db_system');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_name', 'group_description', 'group_leader_user_id', 'group_leader_contact'], 'default', 'value' => null],
            [['group_leader_user_id', 'group_leader_contact'], 'integer'],
            [['created_at'], 'safe'],
            [['group_name', 'group_description'], 'string', 'max' => 255],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
        ];
    }

    /**
     * column status ENUM value labels
     * @return string[]
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_ACTIVE => 'ACTIVE',
            self::STATUS_INACTIVE => 'INACTIVE',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_name' => 'Group Name',
            'group_description' => 'Group Description',
            'group_leader_user_id' => 'Group Leader',
            'group_leader_contact' => 'Group Leader Contact',
            'status' => 'Group Status',
            'created_at' => 'Created At',
        ];
    }

    public function getGroupLeaderProfile()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'group_leader_user_id']);
    }
}
