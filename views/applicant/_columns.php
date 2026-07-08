<?php

use app\models\Applicant;
use yii\bootstrap4\Html;
use yii\helpers\Url;

return [
    // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'width' => '20px',
    // ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'id',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'personal_information_firstname',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'personal_information_lastname',
    ],
    // [
    //     'class' => '\kartik\grid\DataColumn',
    //     'attribute' => 'personal_information_middlename',
    // ],
    // [
    //     'class' => '\kartik\grid\DataColumn',
    //     'attribute' => 'personal_information_extension_name',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'personal_information_gender',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'personal_information_contact',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'personal_information_birthday',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'personal_information_age',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'personal_information_civil_status',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'address_details_region',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'address_details_province',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'address_details_city_municipality',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'address_details_brgy',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'address_details_district_street',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'employment_information_occupation',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'employment_information_sector_of_employment',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'employment_information_salary',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'emergency_contact_fullname',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'emergency_contact_number',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'emergency_contact_address',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'volunteer_details_registration_type',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'volunteer_details_group_name',
        'label' => 'Alliance',
        'value' => function ($model) {
            return $model->allianceOrganizationName;
        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'status',
        'format' => 'raw',
        'value' => function ($model) {
            $status = strtolower($model->status);

            switch ($status) {
                case 'approved':
                    $class = 'badge bg-success';
                    break;

                case 'pending':
                    $class = 'badge bg-warning text-dark';
                    break;

                case 'rejected':
                    $class = 'badge bg-danger';
                    break;

                default:
                    $class = 'badge bg-secondary';
                    break;
            }

            return "<span class='{$class}'>" . ucfirst($status) . "</span>";
        },
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'endorsement_sponsor_who_invite',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'document_verification_uplink_id',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'document_verification_uplink_signature',
    // ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'created_at',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'noWrap' => true,
        'template' => '{view} {update} {approve} {reject}',
        'vAlign' => 'middle',

        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },

        'visibleButtons' => [

            'update' => function ($model) {
                return $model->status === Applicant::STATUS_PENDING;
            },

        ],

        'buttons' => [

            'approve' => function ($url, $model) {

                if ($model->status !== Applicant::STATUS_PENDING) {
                    return '';
                }

                return Html::a(
                    '<i class="fas fa-check"></i>',
                    ['approve', 'id' => $model->id],
                    [
                        'role' => 'modal-remote',
                        'class' => 'btn btn-sm btn-outline-success',
                        'title' => 'Approve',
                        'data-request-method' => 'post',
                        'data-confirm-title' => 'Approve',
                        'data-confirm-message' => 'Are you sure you want to approve this application?',
                    ]
                );
            },

            'reject' => function ($url, $model) {

                if ($model->status !== Applicant::STATUS_PENDING) {
                    return '';
                }

                return Html::a(
                    '<i class="fas fa-times"></i>',
                    ['reject', 'id' => $model->id],
                    [
                        'role' => 'modal-remote',
                        'class' => 'btn btn-sm btn-outline-danger',
                        'title' => 'Reject',
                        'data-request-method' => 'post',
                        'data-confirm-title' => 'Reject',
                        'data-confirm-message' => 'Are you sure you want to reject this application?',
                    ]
                );
            },

        ],

        'viewOptions' => [
            'role' => 'modal-remote',
            'title' => 'View',
            'data-toggle' => 'tooltip',
            'class' => 'btn btn-sm btn-outline-success',
        ],

        'updateOptions' => [
            'role' => 'modal-remote',
            'title' => 'Update',
            'data-toggle' => 'tooltip',
            'class' => 'btn btn-sm btn-outline-primary',
        ],
    ],

];
