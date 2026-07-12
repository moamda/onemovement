<?php
/**
 * @noinspection PhpClassNameMismatchInspection
 */

namespace app\models;

use Yii;

/**
 * This is the model class for table "member_activity".
 *
 * @property int $id
 * @property int $member_id
 * @property int $activity_id
 */
class MemberActivity extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'member_activity';
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
            [['member_id', 'activity_id'], 'required'],
            [['member_id', 'activity_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => 'Member ID',
            'activity_id' => 'Activity ID',
        ];
    }

    public function getActivity()
    {
        return $this->hasOne(Activity::class, [
            'id' => 'activity_id',
        ]);
    }
}
