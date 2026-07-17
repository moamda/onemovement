<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "beneficiary".
 *
 * @property int $id
 * @property int $applicant_id
 * @property string $beneficiary_lastname
 * @property string $beneficiary_firstname
 * @property string|null $beneficiary_middlename
 * @property string|null $beneficiary_extension_name
 * @property string $beneficiary_relationship
 * @property string $beneficiary_birthdate
 * @property string $beneficiary_gender
 * @property string $beneficiary_civil_status
 * @property string $created_at
 */
class Beneficiary extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const BENEFICIARY_EXTENSION_NAME_JR = 'JR';
    const BENEFICIARY_EXTENSION_NAME_SR = 'SR';
    const BENEFICIARY_EXTENSION_NAME_I = 'I';
    const BENEFICIARY_EXTENSION_NAME_II = 'II';
    const BENEFICIARY_EXTENSION_NAME_III = 'III';
    const BENEFICIARY_EXTENSION_NAME_IV = 'IV';
    const BENEFICIARY_EXTENSION_NAME_V = 'V';
    const BENEFICIARY_GENDER_MALE = 'MALE';
    const BENEFICIARY_GENDER_FEMALE = 'FEMALE';
    const BENEFICIARY_GENDER_OTHERS = 'OTHERS';
    const BENEFICIARY_GENDER = '';
    const BENEFICIARY_CIVIL_STATUS_SINGLE = 'SINGLE';
    const BENEFICIARY_CIVIL_STATUS_MARRIED = 'MARRIED';
    const BENEFICIARY_CIVIL_STATUS_WIDOWED = 'WIDOWED';
    const BENEFICIARY_CIVIL_STATUS_SEPARATED = 'SEPARATED';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'beneficiary';
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
            [['beneficiary_middlename', 'beneficiary_extension_name'], 'default', 'value' => null],
            [
                [
                    'beneficiary_lastname',
                    'beneficiary_firstname',
                    'beneficiary_relationship',
                    'beneficiary_birthdate',
                    'beneficiary_gender',
                    'beneficiary_civil_status'
                ],
                'required',
                'on' => 'applicant-form'
            ],
            [['applicant_id'], 'integer'],
            [['beneficiary_extension_name', 'beneficiary_gender', 'beneficiary_civil_status'], 'string'],
            [['beneficiary_birthdate', 'created_at'], 'safe'],
            [['beneficiary_lastname', 'beneficiary_firstname', 'beneficiary_middlename', 'beneficiary_relationship'], 'string', 'max' => 100],
            ['beneficiary_extension_name', 'in', 'range' => array_keys(self::optsBeneficiaryExtensionName())],
            ['beneficiary_gender', 'in', 'range' => array_keys(self::optsBeneficiaryGender())],
            ['beneficiary_civil_status', 'in', 'range' => array_keys(self::optsBeneficiaryCivilStatus())],

        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios['applicant-form'] = [
            'beneficiary_lastname',
            'beneficiary_firstname',
            'beneficiary_middlename',
            'beneficiary_extension_name',
            'beneficiary_relationship',
            'beneficiary_birthdate',
            'beneficiary_gender',
            'beneficiary_civil_status',
        ];

        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'applicant_id' => 'Applicant ID',
            'beneficiary_lastname' => 'Beneficiary Lastname',
            'beneficiary_firstname' => 'Beneficiary Firstname',
            'beneficiary_middlename' => 'Beneficiary Middlename',
            'beneficiary_extension_name' => 'Beneficiary Extension Name',
            'beneficiary_relationship' => 'Beneficiary Relationship',
            'beneficiary_birthdate' => 'Beneficiary Birthdate',
            'beneficiary_gender' => 'Beneficiary Gender',
            'beneficiary_civil_status' => 'Beneficiary Civil Status',
            'created_at' => 'Created At',
        ];
    }


    /**
     * column beneficiary_extension_name ENUM value labels
     * @return string[]
     */
    public static function optsBeneficiaryExtensionName()
    {
        return [
            self::BENEFICIARY_EXTENSION_NAME_JR => 'JR',
            self::BENEFICIARY_EXTENSION_NAME_SR => 'SR',
            self::BENEFICIARY_EXTENSION_NAME_I => 'I',
            self::BENEFICIARY_EXTENSION_NAME_II => 'II',
            self::BENEFICIARY_EXTENSION_NAME_III => 'III',
            self::BENEFICIARY_EXTENSION_NAME_IV => 'IV',
            self::BENEFICIARY_EXTENSION_NAME_V => 'V',
        ];
    }

    /**
     * column beneficiary_gender ENUM value labels
     * @return string[]
     */
    public static function optsBeneficiaryGender()
    {
        return [
            self::BENEFICIARY_GENDER_MALE => 'MALE',
            self::BENEFICIARY_GENDER_FEMALE => 'FEMALE',
            self::BENEFICIARY_GENDER_OTHERS => 'OTHERS',
        ];
    }

    /**
     * column beneficiary_civil_status ENUM value labels
     * @return string[]
     */
    public static function optsBeneficiaryCivilStatus()
    {
        return [
            self::BENEFICIARY_CIVIL_STATUS_SINGLE => 'SINGLE',
            self::BENEFICIARY_CIVIL_STATUS_MARRIED => 'MARRIED',
            self::BENEFICIARY_CIVIL_STATUS_WIDOWED => 'WIDOWED',
            self::BENEFICIARY_CIVIL_STATUS_SEPARATED => 'SEPARATED',
        ];
    }

    /**
     * @return string
     */
    public function displayBeneficiaryExtensionName()
    {
        return self::optsBeneficiaryExtensionName()[$this->beneficiary_extension_name];
    }

    /**
     * @return bool
     */
    public function isBeneficiaryExtensionNameJr()
    {
        return $this->beneficiary_extension_name === self::BENEFICIARY_EXTENSION_NAME_JR;
    }

    public function setBeneficiaryExtensionNameToJr()
    {
        $this->beneficiary_extension_name = self::BENEFICIARY_EXTENSION_NAME_JR;
    }

    /**
     * @return bool
     */
    public function isBeneficiaryExtensionNameSr()
    {
        return $this->beneficiary_extension_name === self::BENEFICIARY_EXTENSION_NAME_SR;
    }

    public function setBeneficiaryExtensionNameToSr()
    {
        $this->beneficiary_extension_name = self::BENEFICIARY_EXTENSION_NAME_SR;
    }

    /**
     * @return bool
     */
    public function isBeneficiaryExtensionNameI()
    {
        return $this->beneficiary_extension_name === self::BENEFICIARY_EXTENSION_NAME_I;
    }

    public function setBeneficiaryExtensionNameToI()
    {
        $this->beneficiary_extension_name = self::BENEFICIARY_EXTENSION_NAME_I;
    }

    /**
     * @return bool
     */
    public function isBeneficiaryExtensionNameIi()
    {
        return $this->beneficiary_extension_name === self::BENEFICIARY_EXTENSION_NAME_II;
    }

    public function setBeneficiaryExtensionNameToIi()
    {
        $this->beneficiary_extension_name = self::BENEFICIARY_EXTENSION_NAME_II;
    }

    /**
     * @return bool
     */
    public function isBeneficiaryExtensionNameIii()
    {
        return $this->beneficiary_extension_name === self::BENEFICIARY_EXTENSION_NAME_III;
    }

    public function setBeneficiaryExtensionNameToIii()
    {
        $this->beneficiary_extension_name = self::BENEFICIARY_EXTENSION_NAME_III;
    }

    /**
     * @return bool
     */
    public function isBeneficiaryExtensionNameIv()
    {
        return $this->beneficiary_extension_name === self::BENEFICIARY_EXTENSION_NAME_IV;
    }

    public function setBeneficiaryExtensionNameToIv()
    {
        $this->beneficiary_extension_name = self::BENEFICIARY_EXTENSION_NAME_IV;
    }

    /**
     * @return bool
     */
    public function isBeneficiaryExtensionNameV()
    {
        return $this->beneficiary_extension_name === self::BENEFICIARY_EXTENSION_NAME_V;
    }

    public function setBeneficiaryExtensionNameToV()
    {
        $this->beneficiary_extension_name = self::BENEFICIARY_EXTENSION_NAME_V;
    }

    /**
     * @return string
     */
    public function displayBeneficiaryGender()
    {
        return self::optsBeneficiaryGender()[$this->beneficiary_gender];
    }

    /**
     * @return bool
     */
    public function isBeneficiaryGenderMale()
    {
        return $this->beneficiary_gender === self::BENEFICIARY_GENDER_MALE;
    }

    public function setBeneficiaryGenderToMale()
    {
        $this->beneficiary_gender = self::BENEFICIARY_GENDER_MALE;
    }

    /**
     * @return bool
     */
    public function isBeneficiaryGenderFemale()
    {
        return $this->beneficiary_gender === self::BENEFICIARY_GENDER_FEMALE;
    }

    public function setBeneficiaryGenderToFemale()
    {
        $this->beneficiary_gender = self::BENEFICIARY_GENDER_FEMALE;
    }

    /**
     * @return bool
     */
    public function isBeneficiaryGenderOthers()
    {
        return $this->beneficiary_gender === self::BENEFICIARY_GENDER_OTHERS;
    }

    public function setBeneficiaryGenderToOthers()
    {
        $this->beneficiary_gender = self::BENEFICIARY_GENDER_OTHERS;
    }

    /**
     * @return bool
     */
    public function isBeneficiaryGender()
    {
        return $this->beneficiary_gender === self::BENEFICIARY_GENDER;
    }

    public function setBeneficiaryGenderTo()
    {
        $this->beneficiary_gender = self::BENEFICIARY_GENDER;
    }

    /**
     * @return string
     */
    public function displayBeneficiaryCivilStatus()
    {
        return self::optsBeneficiaryCivilStatus()[$this->beneficiary_civil_status];
    }

    /**
     * @return bool
     */
    public function isBeneficiaryCivilStatusSingle()
    {
        return $this->beneficiary_civil_status === self::BENEFICIARY_CIVIL_STATUS_SINGLE;
    }

    public function setBeneficiaryCivilStatusToSingle()
    {
        $this->beneficiary_civil_status = self::BENEFICIARY_CIVIL_STATUS_SINGLE;
    }

    /**
     * @return bool
     */
    public function isBeneficiaryCivilStatusMarried()
    {
        return $this->beneficiary_civil_status === self::BENEFICIARY_CIVIL_STATUS_MARRIED;
    }

    public function setBeneficiaryCivilStatusToMarried()
    {
        $this->beneficiary_civil_status = self::BENEFICIARY_CIVIL_STATUS_MARRIED;
    }

    /**
     * @return bool
     */
    public function isBeneficiaryCivilStatusWidowed()
    {
        return $this->beneficiary_civil_status === self::BENEFICIARY_CIVIL_STATUS_WIDOWED;
    }

    public function setBeneficiaryCivilStatusToWidowed()
    {
        $this->beneficiary_civil_status = self::BENEFICIARY_CIVIL_STATUS_WIDOWED;
    }

    /**
     * @return bool
     */
    public function isBeneficiaryCivilStatusSeparated()
    {
        return $this->beneficiary_civil_status === self::BENEFICIARY_CIVIL_STATUS_SEPARATED;
    }

    public function setBeneficiaryCivilStatusToSeparated()
    {
        $this->beneficiary_civil_status = self::BENEFICIARY_CIVIL_STATUS_SEPARATED;
    }
}
