<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "member".
 *
 * @property int $id
 * @property string|null $status
 * @property int $applicant_id
 * @property int|null $alliance_id
 * @property string $created_at
 */
class Member extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'member';
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
            [['alliance_id'], 'default', 'value' => null],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],

            [['status'], 'string'],

            [['applicant_id'], 'required'],

            [['applicant_id', 'alliance_id'], 'integer'],

            [['created_at'], 'safe'],

            ['status', 'in', 'range' => array_keys(self::optsStatus())],

            [
                ['applicant_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Applicant::class,
                'targetAttribute' => ['applicant_id' => 'id'],
            ],

            [
                ['alliance_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Alliance::class,
                'targetAttribute' => ['alliance_id' => 'id'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'applicant_id' => 'Applicant ID',
            'alliance_id' => 'Alliance ID',
            'created_at' => 'Created At',
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
     * @return string
     */
    public function displayStatus()
    {
        return self::optsStatus()[$this->status];
    }

    /**
     * @return bool
     */
    public function isStatusActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function setStatusToActive()
    {
        $this->status = self::STATUS_ACTIVE;
    }

    /**
     * @return bool
     */
    public function isStatusInactive()
    {
        return $this->status === self::STATUS_INACTIVE;
    }

    public function setStatusToInactive()
    {
        $this->status = self::STATUS_INACTIVE;
    }

    public function getApplicant()
    {
        return $this->hasOne(Applicant::class, [
            'id' => 'applicant_id',
        ]);
    }

    public function getAlliance()
    {
        return $this->hasOne(Alliance::class, [
            'id' => 'alliance_id',
        ]);
    }

    public function getMemberActivities()
    {
        return $this->hasMany(MemberActivity::class, [
            'member_id' => 'id'
        ]);
    }

    public function getActivity()
    {
        return $this->hasOne(Activity::class, [
            'id' => 'activity_id'
        ]);
    }

    public function getBeneficiaries()
    {
        return $this->hasMany(Beneficiary::class, [
            'applicant_id' => 'id'
        ]);
    }
}
