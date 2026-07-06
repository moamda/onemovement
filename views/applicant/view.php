<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Applicant */
?>
<div class="applicant-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'status',
            'personal_information_firstname',
            'personal_information_lastname',
            'personal_information_middlename',
            'personal_information_extension_name',
            'personal_information_gender',
            'personal_information_contact',
            'personal_information_birthday',
            'personal_information_age',
            'personal_information_civil_status',
            'address_details_region',
            'address_details_province',
            'address_details_city_municipality',
            'address_details_brgy',
            'address_details_district_street',
            'employment_information_occupation',
            'employment_information_sector_of_employment',
            'employment_information_salary',
            'emergency_contact_fullname',
            'emergency_contact_number',
            'emergency_contact_address',
            'volunteer_details_registration_type',
            'endorsement_sponsor_who_invite',
            'document_verification_uplink_id',
            'document_verification_uplink_signature',
        ],
    ]) ?>

</div>
