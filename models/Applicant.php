<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Applicant".
 *
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $middlename
 * @property string $gender
 * @property string $contact
 * @property string $birthday
 */
class Applicant extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';
    const GENDER_OTHERS = 'others';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Applicant';
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
            [['firstname', 'lastname', 'middlename', 'gender', 'contact', 'birthday'], 'required'],
            [['gender'], 'string'],
            [['birthday'], 'safe'],
            [['firstname', 'lastname', 'middlename'], 'string', 'max' => 50],
            [['contact'], 'string', 'max' => 20],
            ['gender', 'in', 'range' => array_keys(self::optsGender())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'middlename' => 'Middlename',
            'gender' => 'Gender',
            'contact' => 'Contact',
            'birthday' => 'Birthday',
        ];
    }


    /**
     * column gender ENUM value labels
     * @return string[]
     */
    public static function optsGender()
    {
        return [
            self::GENDER_MALE => 'male',
            self::GENDER_FEMALE => 'female',
            self::GENDER_OTHERS => 'others',
        ];
    }

    /**
     * @return string
     */
    public function displayGender()
    {
        return self::optsGender()[$this->gender];
    }

    /**
     * @return bool
     */
    public function isGenderMale()
    {
        return $this->gender === self::GENDER_MALE;
    }

    public function setGenderToMale()
    {
        $this->gender = self::GENDER_MALE;
    }

    /**
     * @return bool
     */
    public function isGenderFemale()
    {
        return $this->gender === self::GENDER_FEMALE;
    }

    public function setGenderToFemale()
    {
        $this->gender = self::GENDER_FEMALE;
    }

    /**
     * @return bool
     */
    public function isGenderOthers()
    {
        return $this->gender === self::GENDER_OTHERS;
    }

    public function setGenderToOthers()
    {
        $this->gender = self::GENDER_OTHERS;
    }
}
