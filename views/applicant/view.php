<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Applicant */
?>
<div class="applicant-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
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
            // [
            //     'attribute' => 'address_details_region',
            //     'value' => function ($model) {
            //         return $model->region ? $model->region->name : null;
            //     },
            // ],
            // [
            //     'attribute' => 'address_details_province',
            //     'value' => function ($model) {
            //         return $model->province ? $model->province->name : null;
            //     },
            // ],
            // [
            //     'attribute' => 'address_details_city_municipality',
            //     'value' => function ($model) {
            //         return $model->municipality ? $model->municipality->name : null;
            //     },
            // ],
            // [
            //     'attribute' => 'address_details_brgy',
            //     'value' => function ($model) {
            //         return $model->barangay ? $model->barangay->name : null;
            //     },
            // ],
            'address_details_district_street',
            'employment_information_occupation',
            'employment_information_sector_of_employment',
            'employment_information_salary',
            'emergency_contact_fullname',
            'emergency_contact_number',
            'emergency_contact_address',
            'volunteer_details_registration_type',
            'volunteer_details_group_name',
            'endorsement_sponsor_who_invite',
            [
                'attribute' => 'document_verification_uplink_id',
                'format' => ['image', ['width' => '200']],
                'value' => function ($model) {
                    return Yii::getAlias('@web') . '/' . $model->document_verification_uplink_id;
                },
            ],
            [
                'attribute' => 'document_verification_uplink_signature',
                'format' => ['image', ['width' => '200']],
                'value' => function ($model) {
                    return Yii::getAlias('@web') . '/' . $model->document_verification_uplink_signature;
                },
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime(
                        $model->created_at,
                        'MMMM d, yyyy h:mm:ss a'
                    );
                },
            ],
        ],
    ]) ?>

</div>