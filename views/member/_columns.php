<?php

use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'firstname',
        'label' => 'First Name',
        'value' => function ($model) {
            return $model->applicant->personal_information_firstname ?? null;
        },
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'lastname',
        'label' => 'Last Name',
        'value' => function ($model) {
            return $model->applicant->personal_information_lastname ?? null;
        },
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'contact',
        'label' => 'Contact',
        'value' => function ($model) {
            return $model->applicant->personal_information_contact ?? null;
        },
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'registration_type',
        'label' => 'Registration Type',
        'value' => function ($model) {
            return $model->applicant->displayVolunteerDetailsRegistrationType();
        },
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'alliance_name',
        'label' => 'Alliance',
        'value' => function ($model) {
            return $model->alliance
                ? $model->alliance->organization
                : '-';
        },
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'status',
    ],

    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'noWrap' => true,
        'vAlign' => 'middle',
        'template' => '{view} {update} {assign-activities} {activate} {deactivate}',

        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $model->id]);
        },

        'buttons' => [

            'assign-activities' => function ($url, $model, $key) {

                return \yii\helpers\Html::a(
                    '<i class="fas fa-tasks"></i>',
                    ['assign-activities', 'id' => $model->id],
                    [
                        'title' => 'Assign Activities',
                        'class' => 'btn btn-sm btn-outline-warning',
                        'role' => 'modal-remote',
                        'data-toggle' => 'tooltip',
                    ]
                );
            },

            'view' => function ($url, $model) {
                return \yii\helpers\Html::a(
                    '<i class="fas fa-eye"></i>',
                    $url,
                    [
                        'role' => 'modal-remote',
                        'title' => 'View',
                        'class' => 'btn btn-sm btn-outline-success',
                        'data-toggle' => 'tooltip',
                    ]
                );
            },

            'update' => function ($url, $model) {
                return \yii\helpers\Html::a(
                    '<i class="fas fa-edit"></i>',
                    $url,
                    [
                        'role' => 'modal-remote',
                        'title' => 'Update',
                        'class' => 'btn btn-sm btn-outline-primary',
                        'data-toggle' => 'tooltip',
                    ]
                );
            },

            'activate' => function ($url, $model) {

                if ($model->status == \app\models\Member::STATUS_ACTIVE) {
                    return '';
                }

                return \yii\helpers\Html::a(
                    '<i class="fas fa-check-circle"></i>',
                    $url,
                    [
                        'title' => 'Activate',
                        'class' => 'btn btn-sm btn-outline-success',
                        'data-method' => 'post',
                        'data-confirm' => 'Activate this member?',
                        'data-pjax' => 0,
                    ]
                );
            },

            'deactivate' => function ($url, $model) {

                if ($model->status == \app\models\Member::STATUS_INACTIVE) {
                    return '';
                }

                return \yii\helpers\Html::a(
                    '<i class="fas fa-ban"></i>',
                    $url,
                    [
                        'title' => 'Deactivate',
                        'class' => 'btn btn-sm btn-outline-warning',
                        'data-method' => 'post',
                        'data-confirm' => 'Deactivate this member?',
                        'data-pjax' => 0,
                    ]
                );
            },
        ],
    ],
];
