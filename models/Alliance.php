<?php

namespace app\models;

use app\modules\admin\models\Profile;
use Yii;

/**
 * This is the model class for table "alliance".
 *
 * @property int $id
 * @property string|null $organization
 * @property string|null $area_of_ceverage
 * @property int|null $estimated_members
 * @property int|null $alliance_leader_user_id
 * @property int|null $alliance_leader_contact
 * @property string $created_at
 * @property string|null $alliance_leader_position
 */
class Alliance extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ALLIANCE_LEADER_POSITION_PRESIDENT = 'President';
    const ALLIANCE_LEADER_POSITION_CHAPTER_PRESIDENT = 'Chapter President';
    const ALLIANCE_LEADER_POSITION_CHAIRMAN = 'Chairman';
    const ALLIANCE_LEADER_POSITION_VICE_PRESIDENT = 'Vice President';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alliance';
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
            [['organization', 'area_of_ceverage', 'estimated_members', 'alliance_leader_user_id', 'alliance_leader_contact', 'alliance_leader_position'], 'default', 'value' => null],
            [['estimated_members', 'alliance_leader_user_id', 'alliance_leader_contact'], 'integer'],
            [['created_at'], 'safe'],
            [['alliance_leader_position'], 'string'],
            [['organization', 'area_of_ceverage'], 'string', 'max' => 255],
            ['alliance_leader_position', 'in', 'range' => array_keys(self::optsAllianceLeaderPosition())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'organization' => 'Organization',
            'area_of_ceverage' => 'Area Of Ceverage',
            'estimated_members' => 'Estimated Members',
            'alliance_leader_user_id' => 'Alliance Leader User ID',
            'alliance_leader_contact' => 'Alliance Leader Contact',
            'created_at' => 'Created At',
            'alliance_leader_position' => 'Alliance Leader Position',
        ];
    }


    /**
     * column alliance_leader_position ENUM value labels
     * @return string[]
     */
    public static function optsAllianceLeaderPosition()
    {
        return [
            self::ALLIANCE_LEADER_POSITION_PRESIDENT => 'President',
            self::ALLIANCE_LEADER_POSITION_CHAPTER_PRESIDENT => 'Chapter President',
            self::ALLIANCE_LEADER_POSITION_CHAIRMAN => 'Chairman',
            self::ALLIANCE_LEADER_POSITION_VICE_PRESIDENT => 'Vice President',
        ];
    }

    /**
     * @return string
     */
    public function displayAllianceLeaderPosition()
    {
        return self::optsAllianceLeaderPosition()[$this->alliance_leader_position];
    }

    /**
     * @return bool
     */
    public function isAllianceLeaderPositionPresident()
    {
        return $this->alliance_leader_position === self::ALLIANCE_LEADER_POSITION_PRESIDENT;
    }

    public function setAllianceLeaderPositionToPresident()
    {
        $this->alliance_leader_position = self::ALLIANCE_LEADER_POSITION_PRESIDENT;
    }

    /**
     * @return bool
     */
    public function isAllianceLeaderPositionChapterPresident()
    {
        return $this->alliance_leader_position === self::ALLIANCE_LEADER_POSITION_CHAPTER_PRESIDENT;
    }

    public function setAllianceLeaderPositionToChapterPresident()
    {
        $this->alliance_leader_position = self::ALLIANCE_LEADER_POSITION_CHAPTER_PRESIDENT;
    }

    /**
     * @return bool
     */
    public function isAllianceLeaderPositionChairman()
    {
        return $this->alliance_leader_position === self::ALLIANCE_LEADER_POSITION_CHAIRMAN;
    }

    public function setAllianceLeaderPositionToChairman()
    {
        $this->alliance_leader_position = self::ALLIANCE_LEADER_POSITION_CHAIRMAN;
    }

    /**
     * @return bool
     */
    public function isAllianceLeaderPositionVicePresident()
    {
        return $this->alliance_leader_position === self::ALLIANCE_LEADER_POSITION_VICE_PRESIDENT;
    }

    public function setAllianceLeaderPositionToVicePresident()
    {
        $this->alliance_leader_position = self::ALLIANCE_LEADER_POSITION_VICE_PRESIDENT;
    }

    public function getAllianceLeaderProfile()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'alliance_leader_user_id']);
    }
}
