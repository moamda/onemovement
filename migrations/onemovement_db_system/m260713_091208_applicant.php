<?php

use yii\db\Schema;
use yii\db\Migration;

class m260713_091208_applicant extends Migration
{

    public function init()
    {
        $this->db = 'onemovement_db_system';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%applicant}}',
            [
                'id'=> $this->primaryKey(11),
                'status'=> "enum('APPROVED', 'REJECTED', 'PENDING') NOT NULL DEFAULT 'PENDING'",
                'personal_information_firstname'=> $this->string(100)->notNull(),
                'personal_information_lastname'=> $this->string(100)->notNull(),
                'personal_information_middlename'=> $this->string(100)->null()->defaultValue(null),
                'personal_information_extension_name'=> "enum('JR', 'SR', 'I', 'II', 'III', 'IV', 'V') NULL DEFAULT NULL",
                'personal_information_gender'=> "enum('MALE', 'FEMALE', 'OTHERS') NOT NULL",
                'personal_information_contact'=> $this->string(20)->notNull(),
                'personal_information_email'=> $this->string(255)->notNull(),
                'personal_information_birthday'=> $this->date()->notNull(),
                'personal_information_age'=> $this->integer(11)->notNull(),
                'personal_information_civil_status'=> "enum('SINGLE', 'MARRIED', 'WIDOWED', 'SEPARATED', 'DIVORCED') NOT NULL",
                'address_details_region'=> $this->integer(11)->notNull(),
                'address_details_province'=> $this->integer(11)->notNull(),
                'address_details_city_municipality'=> $this->integer(11)->notNull(),
                'address_details_brgy'=> $this->integer(11)->notNull(),
                'address_details_district_street'=> $this->string(255)->notNull(),
                'employment_information_occupation'=> $this->string(255)->notNull(),
                'employment_information_sector_of_employment'=> "enum('N/A', 'PRIVATE', 'GOVERNMENT') NOT NULL",
                'employment_information_salary'=> $this->integer(11)->notNull(),
                'emergency_contact_fullname'=> $this->string(100)->notNull(),
                'emergency_contact_number'=> $this->string(20)->notNull(),
                'emergency_contact_address'=> $this->string(255)->notNull(),
                'volunteer_details_registration_type'=> "enum('INDIVIDUAL', 'ALLIANCE', 'SECTORIAL') NOT NULL",
                'volunteer_details_group_name'=> $this->integer(11)->null()->defaultValue(null),
                'endorsement_sponsor_who_invite'=> $this->string(255)->notNull(),
                'document_verification_uplink_id'=> $this->string(255)->null()->defaultValue(null),
                'document_verification_uplink_signature'=> $this->string(255)->null()->defaultValue(null),
                'created_at'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%applicant}}');
    }
}
