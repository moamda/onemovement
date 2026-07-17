<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "applicant".
 *
 * @property int $id
 * @property string $status
 * @property string $personal_information_firstname
 * @property string $personal_information_lastname
 * @property string|null $personal_information_middlename
 * @property string|null $personal_information_extension_name
 * @property string $personal_information_gender
 * @property string $personal_information_contact
 * @property string $personal_information_birthday
 * @property string $personal_information_email 
 * @property int $personal_information_age
 * @property string $personal_information_civil_status
 * @property int $address_details_region
 * @property int $address_details_province
 * @property int $address_details_city_municipality
 * @property int $address_details_brgy
 * @property string $address_details_district_street
 * @property string $employment_information_occupation
 * @property string $employment_information_sector_of_employment
 * @property int $employment_information_salary
 * @property string $emergency_contact_fullname
 * @property string $emergency_contact_number
 * @property string $emergency_contact_address
 * @property string $volunteer_details_registration_type
 * @property int|null $volunteer_details_group_name
 * @property string $endorsement_sponsor_who_invite
 * @property string $document_verification_uplink_id
 * @property string $document_verification_uplink_signature
 * @property string|null $document_verification_uplink_id
 * @property string|null $document_verification_uplink_signature
 * @property string $created_at
 */
class Applicant extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATUS_APPROVED = 'APPROVED';
    const STATUS_REJECTED = 'REJECTED';
    const STATUS_PENDING = 'PENDING';
    const PERSONAL_INFORMATION_EXTENSION_NAME_NA = 'N/A';
    const PERSONAL_INFORMATION_EXTENSION_NAME_JR = 'JR';
    const PERSONAL_INFORMATION_EXTENSION_NAME_SR = 'SR';
    const PERSONAL_INFORMATION_EXTENSION_NAME_I = 'I';
    const PERSONAL_INFORMATION_EXTENSION_NAME_II = 'II';
    const PERSONAL_INFORMATION_EXTENSION_NAME_III = 'III';
    const PERSONAL_INFORMATION_EXTENSION_NAME_IV = 'IV';
    const PERSONAL_INFORMATION_EXTENSION_NAME_V = 'V';
    const PERSONAL_INFORMATION_GENDER_MALE = 'MALE';
    const PERSONAL_INFORMATION_GENDER_FEMALE = 'FEMALE';
    const PERSONAL_INFORMATION_GENDER_OTHERS = 'OTHERS';
    const PERSONAL_INFORMATION_CIVIL_STATUS_SINGLE = 'SINGLE';
    const PERSONAL_INFORMATION_CIVIL_STATUS_MARRIED = 'MARRIED';
    const PERSONAL_INFORMATION_CIVIL_STATUS_WIDOWED = 'WIDOWED';
    const PERSONAL_INFORMATION_CIVIL_STATUS_SEPARATED = 'SEPARATED';
    const PERSONAL_INFORMATION_CIVIL_STATUS_DIVORCED = 'DIVORCED';
    const EMPLOYMENT_INFORMATION_SECTOR_OF_EMPLOYMENT_NA = 'N/A';
    const EMPLOYMENT_INFORMATION_SECTOR_OF_EMPLOYMENT_PRIVATE = 'PRIVATE';
    const EMPLOYMENT_INFORMATION_SECTOR_OF_EMPLOYMENT_GOVERNMENT = 'GOVERNMENT';
    const VOLUNTEER_DETAILS_REGISTRATION_TYPE_INDIVIDUAL = 'INDIVIDUAL';
    const VOLUNTEER_DETAILS_REGISTRATION_TYPE_ALLIANCE = 'ALLIANCE';
    const VOLUNTEER_DETAILS_REGISTRATION_TYPE_SECTORIAL = 'SECTORIAL';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'applicant';
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
            [['personal_information_middlename', 'personal_information_extension_name'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 'PENDING'],
            [['status', 'personal_information_extension_name', 'personal_information_gender', 'personal_information_civil_status', 'employment_information_sector_of_employment', 'volunteer_details_registration_type'], 'string'],
            [['personal_information_firstname', 'personal_information_lastname', 'personal_information_gender', 'personal_information_contact', 'personal_information_birthday', 'personal_information_age', 'personal_information_civil_status', 'address_details_region', 'address_details_province', 'address_details_city_municipality', 'address_details_brgy', 'address_details_district_street', 'employment_information_occupation', 'employment_information_sector_of_employment', 'employment_information_salary', 'emergency_contact_fullname', 'emergency_contact_number', 'emergency_contact_address', 'volunteer_details_registration_type', 'endorsement_sponsor_who_invite'], 'required'],
            [['personal_information_birthday', 'created_at'], 'safe'],
            [['personal_information_age', 'address_details_region', 'address_details_province', 'address_details_city_municipality', 'address_details_brgy', 'employment_information_salary', 'volunteer_details_group_name'], 'integer'],
            [['personal_information_firstname', 'personal_information_lastname', 'personal_information_middlename', 'emergency_contact_fullname'], 'string', 'max' => 100],
            [['personal_information_contact', 'emergency_contact_number'], 'string', 'max' => 20],
            [['address_details_district_street', 'employment_information_occupation', 'emergency_contact_address', 'endorsement_sponsor_who_invite'], 'string', 'max' => 255],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
            ['personal_information_extension_name', 'in', 'range' => array_keys(self::optsPersonalInformationExtensionName())],
            ['personal_information_gender', 'in', 'range' => array_keys(self::optsPersonalInformationGender())],
            ['personal_information_civil_status', 'in', 'range' => array_keys(self::optsPersonalInformationCivilStatus())],
            ['employment_information_sector_of_employment', 'in', 'range' => array_keys(self::optsEmploymentInformationSectorOfEmployment())],
            ['volunteer_details_registration_type', 'in', 'range' => array_keys(self::optsVolunteerDetailsRegistrationType())],

            [
                ['document_verification_uplink_id', 'document_verification_uplink_signature'],
                'required',
                'on' => 'applicant-form',
            ],
            [
                ['document_verification_uplink_id', 'document_verification_uplink_signature'],
                'file',
                'skipOnEmpty' => true,
                'extensions' => 'jpg, jpeg, png',
                'maxFiles' => 1,
                'maxSize' => 2 * 1024 * 1024,
            ],
            ['personal_information_email', 'trim'],
            ['personal_information_email', 'safe'],
            ['personal_information_email', 'email'],
            ['personal_information_email', 'string', 'max' => 255],

            [
                ['volunteer_details_group_name'],
                'required',
                'when' => function ($model) {
                    return $model->volunteer_details_registration_type == self::VOLUNTEER_DETAILS_REGISTRATION_TYPE_ALLIANCE;
                },
                'whenClient' => "function () {
                return $('#registration-type-dropdown').val() == '" . self::VOLUNTEER_DETAILS_REGISTRATION_TYPE_ALLIANCE . "';
                }",
            ],
            [
                ['volunteer_details_group_name'],
                'exist',
                'skipOnEmpty' => true,
                'targetClass' => Alliance::class,
                'targetAttribute' => ['volunteer_details_group_name' => 'id'],
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
            'personal_information_firstname' => 'Firstname',
            'personal_information_lastname' => 'Lastname',
            'personal_information_middlename' => 'Middlename',
            'personal_information_extension_name' => 'Extension Name',
            'personal_information_gender' => 'Gender',
            'personal_information_contact' => 'Contact',
            'personal_information_birthday' => 'Birthday',
            'personal_information_email' => 'Email',
            'personal_information_age' => 'Age',
            'personal_information_civil_status' => 'Civil Status',
            'address_details_region' => 'Region',
            'address_details_province' => 'Province',
            'address_details_city_municipality' => 'City/Municipality',
            'address_details_brgy' => 'Barangay',
            'address_details_district_street' => 'District/Street',
            'employment_information_occupation' => 'Occupation',
            'employment_information_sector_of_employment' => 'Sector Of Employment',
            'employment_information_salary' => 'Salary',
            'emergency_contact_fullname' => 'Emergency Contact Fullname',
            'emergency_contact_number' => 'Emergency Contact Number',
            'emergency_contact_address' => 'Emergency Contact Address',
            'volunteer_details_registration_type' => 'Registration Type',
            'volunteer_details_group_name' => 'Alliance',
            'endorsement_sponsor_who_invite' => 'Endorsement Sponsor Who Invite',
            'document_verification_uplink_id' => 'ID',
            'document_verification_uplink_signature' => 'Signature',
            'created_at' => 'Application Date',
        ];
    }


    /**
     * column status ENUM value labels
     * @return string[]
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_APPROVED => 'APPROVED',
            self::STATUS_REJECTED => 'REJECTED',
            self::STATUS_PENDING => 'PENDING',
        ];
    }

    /**
     * column personal_information_extension_name ENUM value labels
     * @return string[]
     */
    public static function optsPersonalInformationExtensionName()
    {
        return [
            self::PERSONAL_INFORMATION_EXTENSION_NAME_NA => 'N/A',
            self::PERSONAL_INFORMATION_EXTENSION_NAME_JR => 'JR',
            self::PERSONAL_INFORMATION_EXTENSION_NAME_SR => 'SR',
            self::PERSONAL_INFORMATION_EXTENSION_NAME_I => 'I',
            self::PERSONAL_INFORMATION_EXTENSION_NAME_II => 'II',
            self::PERSONAL_INFORMATION_EXTENSION_NAME_III => 'III',
            self::PERSONAL_INFORMATION_EXTENSION_NAME_IV => 'IV',
            self::PERSONAL_INFORMATION_EXTENSION_NAME_V => 'V',
        ];
    }

    /**
     * column personal_information_gender ENUM value labels
     * @return string[]
     */
    public static function optsPersonalInformationGender()
    {
        return [
            self::PERSONAL_INFORMATION_GENDER_MALE => 'MALE',
            self::PERSONAL_INFORMATION_GENDER_FEMALE => 'FEMALE',
            self::PERSONAL_INFORMATION_GENDER_OTHERS => 'OTHERS',
        ];
    }

    /**
     * column personal_information_civil_status ENUM value labels
     * @return string[]
     */
    public static function optsPersonalInformationCivilStatus()
    {
        return [
            self::PERSONAL_INFORMATION_CIVIL_STATUS_SINGLE => 'SINGLE',
            self::PERSONAL_INFORMATION_CIVIL_STATUS_MARRIED => 'MARRIED',
            self::PERSONAL_INFORMATION_CIVIL_STATUS_WIDOWED => 'WIDOWED',
            self::PERSONAL_INFORMATION_CIVIL_STATUS_SEPARATED => 'SEPARATED',
            self::PERSONAL_INFORMATION_CIVIL_STATUS_DIVORCED => 'DIVORCED',
        ];
    }

    /**
     * column employment_information_sector_of_employment ENUM value labels
     * @return string[]
     */
    public static function optsEmploymentInformationSectorOfEmployment()
    {
        return [
            self::EMPLOYMENT_INFORMATION_SECTOR_OF_EMPLOYMENT_NA => 'N/A',
            self::EMPLOYMENT_INFORMATION_SECTOR_OF_EMPLOYMENT_PRIVATE => 'PRIVATE',
            self::EMPLOYMENT_INFORMATION_SECTOR_OF_EMPLOYMENT_GOVERNMENT => 'GOVERNMENT',
        ];
    }

    /**
     * column volunteer_details_registration_type ENUM value labels
     * @return string[]
     */
    public static function optsVolunteerDetailsRegistrationType()
    {
        return [
            self::VOLUNTEER_DETAILS_REGISTRATION_TYPE_INDIVIDUAL => 'INDIVIDUAL',
            self::VOLUNTEER_DETAILS_REGISTRATION_TYPE_ALLIANCE => 'ALLIANCE',
            self::VOLUNTEER_DETAILS_REGISTRATION_TYPE_SECTORIAL => 'SECTORIAL',
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
    public function isStatusApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function setStatusToApproved()
    {
        $this->status = self::STATUS_APPROVED;
    }

    /**
     * @return bool
     */
    public function isStatusRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function setStatusToRejected()
    {
        $this->status = self::STATUS_REJECTED;
    }

    /**
     * @return bool
     */
    public function isStatusPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function setStatusToPending()
    {
        $this->status = self::STATUS_PENDING;
    }

    /**
     * @return string
     */
    public function displayPersonalInformationExtensionName()
    {
        return self::optsPersonalInformationExtensionName()[$this->personal_information_extension_name];
    }

    /**
     * @return bool
     */

    public function isPersonalInformationExtensionNameJr()
    {
        return $this->personal_information_extension_name === self::PERSONAL_INFORMATION_EXTENSION_NAME_JR;
    }

    public function setPersonalInformationExtensionNameToJr()
    {
        $this->personal_information_extension_name = self::PERSONAL_INFORMATION_EXTENSION_NAME_JR;
    }
    /**
     * @return bool
     */
    public function isPersonalInformationExtensionNameNa()
    {
        return $this->personal_information_extension_name === self::PERSONAL_INFORMATION_EXTENSION_NAME_NA;
    }

    public function setPersonalInformationExtensionNameToNa()
    {
        $this->personal_information_extension_name = self::PERSONAL_INFORMATION_EXTENSION_NAME_NA;
    }

    /**
     * @return bool
     */
    public function isPersonalInformationExtensionNameSr()
    {
        return $this->personal_information_extension_name === self::PERSONAL_INFORMATION_EXTENSION_NAME_SR;
    }

    public function setPersonalInformationExtensionNameToSr()
    {
        $this->personal_information_extension_name = self::PERSONAL_INFORMATION_EXTENSION_NAME_SR;
    }

    /**
     * @return bool
     */
    public function isPersonalInformationExtensionNameI()
    {
        return $this->personal_information_extension_name === self::PERSONAL_INFORMATION_EXTENSION_NAME_I;
    }

    public function setPersonalInformationExtensionNameToI()
    {
        $this->personal_information_extension_name = self::PERSONAL_INFORMATION_EXTENSION_NAME_I;
    }

    /**
     * @return bool
     */
    public function isPersonalInformationExtensionNameIi()
    {
        return $this->personal_information_extension_name === self::PERSONAL_INFORMATION_EXTENSION_NAME_II;
    }

    public function setPersonalInformationExtensionNameToIi()
    {
        $this->personal_information_extension_name = self::PERSONAL_INFORMATION_EXTENSION_NAME_II;
    }

    /**
     * @return bool
     */
    public function isPersonalInformationExtensionNameIii()
    {
        return $this->personal_information_extension_name === self::PERSONAL_INFORMATION_EXTENSION_NAME_III;
    }

    public function setPersonalInformationExtensionNameToIii()
    {
        $this->personal_information_extension_name = self::PERSONAL_INFORMATION_EXTENSION_NAME_III;
    }

    /**
     * @return bool
     */
    public function isPersonalInformationExtensionNameIv()
    {
        return $this->personal_information_extension_name === self::PERSONAL_INFORMATION_EXTENSION_NAME_IV;
    }

    public function setPersonalInformationExtensionNameToIv()
    {
        $this->personal_information_extension_name = self::PERSONAL_INFORMATION_EXTENSION_NAME_IV;
    }

    /**
     * @return bool
     */
    public function isPersonalInformationExtensionNameV()
    {
        return $this->personal_information_extension_name === self::PERSONAL_INFORMATION_EXTENSION_NAME_V;
    }

    public function setPersonalInformationExtensionNameToV()
    {
        $this->personal_information_extension_name = self::PERSONAL_INFORMATION_EXTENSION_NAME_V;
    }

    /**
     * @return string
     */
    public function displayPersonalInformationGender()
    {
        return self::optsPersonalInformationGender()[$this->personal_information_gender];
    }

    /**
     * @return bool
     */
    public function isPersonalInformationGenderMale()
    {
        return $this->personal_information_gender === self::PERSONAL_INFORMATION_GENDER_MALE;
    }

    public function setPersonalInformationGenderToMale()
    {
        $this->personal_information_gender = self::PERSONAL_INFORMATION_GENDER_MALE;
    }

    /**
     * @return bool
     */
    public function isPersonalInformationGenderFemale()
    {
        return $this->personal_information_gender === self::PERSONAL_INFORMATION_GENDER_FEMALE;
    }

    public function setPersonalInformationGenderToFemale()
    {
        $this->personal_information_gender = self::PERSONAL_INFORMATION_GENDER_FEMALE;
    }

    /**
     * @return bool
     */
    public function isPersonalInformationGenderOthers()
    {
        return $this->personal_information_gender === self::PERSONAL_INFORMATION_GENDER_OTHERS;
    }

    public function setPersonalInformationGenderToOthers()
    {
        $this->personal_information_gender = self::PERSONAL_INFORMATION_GENDER_OTHERS;
    }

    /**
     * @return string
     */
    public function displayPersonalInformationCivilStatus()
    {
        return self::optsPersonalInformationCivilStatus()[$this->personal_information_civil_status];
    }

    /**
     * @return bool
     */
    public function isPersonalInformationCivilStatusSingle()
    {
        return $this->personal_information_civil_status === self::PERSONAL_INFORMATION_CIVIL_STATUS_SINGLE;
    }

    public function setPersonalInformationCivilStatusToSingle()
    {
        $this->personal_information_civil_status = self::PERSONAL_INFORMATION_CIVIL_STATUS_SINGLE;
    }

    /**
     * @return bool
     */
    public function isPersonalInformationCivilStatusMarried()
    {
        return $this->personal_information_civil_status === self::PERSONAL_INFORMATION_CIVIL_STATUS_MARRIED;
    }

    public function setPersonalInformationCivilStatusToMarried()
    {
        $this->personal_information_civil_status = self::PERSONAL_INFORMATION_CIVIL_STATUS_MARRIED;
    }

    /**
     * @return bool
     */
    public function isPersonalInformationCivilStatusWidowed()
    {
        return $this->personal_information_civil_status === self::PERSONAL_INFORMATION_CIVIL_STATUS_WIDOWED;
    }

    public function setPersonalInformationCivilStatusToWidowed()
    {
        $this->personal_information_civil_status = self::PERSONAL_INFORMATION_CIVIL_STATUS_WIDOWED;
    }

    /**
     * @return bool
     */
    public function isPersonalInformationCivilStatusSeparated()
    {
        return $this->personal_information_civil_status === self::PERSONAL_INFORMATION_CIVIL_STATUS_SEPARATED;
    }

    public function setPersonalInformationCivilStatusToSeparated()
    {
        $this->personal_information_civil_status = self::PERSONAL_INFORMATION_CIVIL_STATUS_SEPARATED;
    }

    public function isPersonalInformationCivilStatusDivorced()
    {
        return $this->personal_information_civil_status === self::PERSONAL_INFORMATION_CIVIL_STATUS_DIVORCED;
    }

    public function setPersonalInformationCivilStatusToDivorced()
    {
        $this->personal_information_civil_status = self::PERSONAL_INFORMATION_CIVIL_STATUS_DIVORCED;
    }

    /**
     * @return string
     */
    public function displayEmploymentInformationSectorOfEmployment()
    {
        return self::optsEmploymentInformationSectorOfEmployment()[$this->employment_information_sector_of_employment];
    }

    /**
     * @return bool
     */
    public function isEmploymentInformationSectorOfEmploymentNa()
    {
        return $this->employment_information_sector_of_employment === self::EMPLOYMENT_INFORMATION_SECTOR_OF_EMPLOYMENT_NA;
    }

    public function setEmploymentInformationSectorOfEmploymentToNa()
    {
        $this->employment_information_sector_of_employment = self::EMPLOYMENT_INFORMATION_SECTOR_OF_EMPLOYMENT_NA;
    }

    /**
     * @return bool
     */
    public function isEmploymentInformationSectorOfEmploymentPrivate()
    {
        return $this->employment_information_sector_of_employment === self::EMPLOYMENT_INFORMATION_SECTOR_OF_EMPLOYMENT_PRIVATE;
    }

    public function setEmploymentInformationSectorOfEmploymentToPrivate()
    {
        $this->employment_information_sector_of_employment = self::EMPLOYMENT_INFORMATION_SECTOR_OF_EMPLOYMENT_PRIVATE;
    }

    /**
     * @return bool
     */
    public function isEmploymentInformationSectorOfEmploymentGovernment()
    {
        return $this->employment_information_sector_of_employment === self::EMPLOYMENT_INFORMATION_SECTOR_OF_EMPLOYMENT_GOVERNMENT;
    }

    public function setEmploymentInformationSectorOfEmploymentToGovernment()
    {
        $this->employment_information_sector_of_employment = self::EMPLOYMENT_INFORMATION_SECTOR_OF_EMPLOYMENT_GOVERNMENT;
    }

    /**
     * @return string
     */
    public function displayVolunteerDetailsRegistrationType()
    {
        return self::optsVolunteerDetailsRegistrationType()[$this->volunteer_details_registration_type];
    }

    /**
     * @return bool
     */
    public function isVolunteerDetailsRegistrationTypeIndividual()
    {
        return $this->volunteer_details_registration_type === self::VOLUNTEER_DETAILS_REGISTRATION_TYPE_INDIVIDUAL;
    }

    public function setVolunteerDetailsRegistrationTypeToIndividual()
    {
        $this->volunteer_details_registration_type = self::VOLUNTEER_DETAILS_REGISTRATION_TYPE_INDIVIDUAL;
    }

    /**
     * @return bool
     */
    public function isVolunteerDetailsRegistrationTypeAlliance()
    {
        return $this->volunteer_details_registration_type === self::VOLUNTEER_DETAILS_REGISTRATION_TYPE_ALLIANCE;
    }

    public function setVolunteerDetailsRegistrationTypeToAlliance()
    {
        $this->volunteer_details_registration_type = self::VOLUNTEER_DETAILS_REGISTRATION_TYPE_ALLIANCE;
    }

    /**
     * @return bool
     */
    public function isVolunteerDetailsRegistrationTypeSectorial()
    {
        return $this->volunteer_details_registration_type === self::VOLUNTEER_DETAILS_REGISTRATION_TYPE_SECTORIAL;
    }

    public function setVolunteerDetailsRegistrationTypeToSectorial()
    {
        $this->volunteer_details_registration_type = self::VOLUNTEER_DETAILS_REGISTRATION_TYPE_SECTORIAL;
    }

    public function getRegion()
    {
        return $this->hasOne(Refregion::class, [
            'psgcCode' => 'address_details_region',
        ]);
    }

    public function getProvince()
    {
        return $this->hasOne(Refprovince::class, [
            'psgcCode' => 'address_details_province',
        ]);
    }

    public function getMunicipality()
    {
        return $this->hasOne(Refcitymun::class, [
            'psgcCode' => 'address_details_city_municipality',
        ]);
    }

    public function getBarangay()
    {
        return $this->hasOne(Refbrgy::class, [
            'brgyCode' => 'address_details_brgy',
        ]);
    }

    public function getAlliance()
    {
        return $this->hasOne(Alliance::class, [
            'id' => 'volunteer_details_group_name',
        ]);
    }

    public function getAllianceOrganizationName()
    {
        return $this->alliance->organization ?? null;
    }

    public function getBeneficiaries()
    {
        return $this->hasMany(Beneficiary::class, ['applicant_id' => 'id']);
    }
}
