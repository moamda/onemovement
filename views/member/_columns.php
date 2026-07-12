<?php

use yii\helpers\Url;

return [
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
        'attribute' => 'middlename',
        'label' => 'Middle Name',
        'value' => function ($model) {
            return $model->applicant->personal_information_middlename ?? null;
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
        'format' => 'raw',
        'value' => function ($model) {
            $status = strtolower($model->status);

            switch ($status) {
                case 'active':
                    $class = 'badge bg-success';
                    break;

                case 'inactive':
                    $class = 'badge bg-danger';
                    break;

                default:
                    $class = 'badge bg-secondary';
                    break;
            }

            return "<span class='{$class}'>" . ucfirst($status) . "</span>";
        },
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
                    Yii::$app->params['bsVersion'] == '4.x'
                        ? '<i class="fas fa-pencil-alt"></i>'
                        : '<span class="glyphicon glyphicon-pencil"></span>',
                    $url,
                    [
                        'role' => 'modal-remote',
                        'title' => Yii::t('yii', 'Update'),
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
                    '<i class="fas fa-check"></i>',
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
                    '<i class="fas fa-times"></i>',
                    $url,
                    [
                        'title' => 'Deactivate',
                        'class' => 'btn btn-sm btn-outline-danger',
                        'data-method' => 'post',
                        'data-confirm' => 'Deactivate this member?',
                        'data-pjax' => 0,
                    ]
                );
            },
        ],
    ],
];
