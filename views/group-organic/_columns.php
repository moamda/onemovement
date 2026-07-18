<?php

use app\modules\admin\models\Profile;
use yii\helpers\Html;
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
        'attribute' => 'group_name',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'group_description',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'group_leader_user_id',
        'label' => 'Group Leader',
        'value' => function ($model) {
            if (empty($model->group_leader_user_id)) {
                return '';
            }

            $profile = Profile::find()
                ->where(['user_id' => $model->group_leader_user_id])
                ->one();

            if (!$profile) {
                return '';
            }

            return trim("{$profile->first_name} {$profile->middle_name} {$profile->last_name}");
        },
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'group_leader_contact',
        'value' => function ($model) {
            return $model->group_leader_contact ?: '';
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
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'created_at',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'noWrap' => 'true',
        'template' => '{view} {update} {activate} {deactivate}',
        'vAlign' => 'middle',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },
        'buttons' => [

            'activate' => function ($url, $model) {
                if ($model->status !== \app\models\GroupOrganic::STATUS_INACTIVE) {
                    return '';
                }

                return Html::a(
                    '<i class="fas fa-check"></i>',
                    ['activate', 'id' => $model->id],
                    [
                        'role' => 'modal-remote',
                        'class' => 'btn btn-sm btn-outline-success',
                        'title' => 'Activate',
                        'data-request-method' => 'post',
                        'data-confirm-title' => 'Activate',
                        'data-confirm-message' => 'Are you sure you want to activate this group organic?',
                    ]
                );
            },

            'deactivate' => function ($url, $model) {
                if ($model->status !== \app\models\GroupOrganic::STATUS_ACTIVE) {
                    return '';
                }

                return Html::a(
                    '<i class="fas fa-times"></i>',
                    ['deactivate', 'id' => $model->id],
                    [
                        'role' => 'modal-remote',
                        'class' => 'btn btn-sm btn-outline-danger',
                        'title' => 'Deactivate',
                        'data-request-method' => 'post',
                        'data-confirm-title' => 'Deactivate',
                        'data-confirm-message' => 'Are you sure you want to deactivate this group organic?',
                    ]
                );
            },

        ],
        'viewOptions' => ['role' => 'modal-remote', 'title' => Yii::t('yii2-ajaxcrud', 'View'), 'data-toggle' => 'tooltip', 'class' => 'btn btn-sm btn-outline-success'],
        'updateOptions' => ['role' => 'modal-remote', 'title' => Yii::t('yii2-ajaxcrud', 'Update'), 'data-toggle' => 'tooltip', 'class' => 'btn btn-sm btn-outline-primary'],
    ],

];
