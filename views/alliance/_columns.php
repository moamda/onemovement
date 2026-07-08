<?php

use app\modules\admin\models\Profile;
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
        'attribute' => 'organization',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'area_of_ceverage',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'estimated_members',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'alliance_leader_user_id',
        'label' => 'Alliance Leader',
        'value' => function ($model) {
            if (empty($model->alliance_leader_user_id)) {
                return '';
            }

            $profile = Profile::find()
                ->where(['user_id' => $model->alliance_leader_user_id])
                ->one();

            if (!$profile) {
                return '';
            }

            return trim("{$profile->first_name} {$profile->middle_name} {$profile->last_name}");
        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'alliance_leader_contact',
        'value' => function ($model) {
            return $model->alliance_leader_contact ?: '';
        },
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'created_at',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'alliance_leader_position',
        'value' => function ($model) {
            return $model->alliance_leader_position ?: '';
        },
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'noWrap' => 'true',
        'template' => '{view} {update} {delete}',
        'vAlign' => 'middle',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },
        'viewOptions' => ['role' => 'modal-remote', 'title' => Yii::t('yii2-ajaxcrud', 'View'), 'data-toggle' => 'tooltip', 'class' => 'btn btn-sm btn-outline-success'],
        'updateOptions' => ['role' => 'modal-remote', 'title' => Yii::t('yii2-ajaxcrud', 'Update'), 'data-toggle' => 'tooltip', 'class' => 'btn btn-sm btn-outline-primary'],
        'deleteOptions' => [
            'role' => 'modal-remote',
            'title' => Yii::t('yii2-ajaxcrud', 'Delete'),
            'class' => 'btn btn-sm btn-outline-danger',
            'data-confirm' => false,
            'data-method' => false, // for overide yii data api
            'data-request-method' => 'post',
            'data-toggle' => 'tooltip',
            'data-confirm-title' => Yii::t('yii2-ajaxcrud', 'Delete'),
            'data-confirm-message' => Yii::t('yii2-ajaxcrud', 'Delete Confirm')
        ],
    ],

];
