<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Alliance */
?>
<div class="alliance-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'organization',
            'area_of_ceverage',
            // 'estimated_members',
            [
                'attribute' => 'alliance_leader_user_id',
                'label' => 'Alliance Leader',
                'value' => fn($model) => $model->allianceLeaderProfile
                    ? trim("{$model->allianceLeaderProfile->first_name} {$model->allianceLeaderProfile->middle_name} {$model->allianceLeaderProfile->last_name}")
                    : '',
            ],
            [
                'attribute' => 'alliance_leader_contact',
                'value' => fn($model) => $model->allianceLeaderProfile->contact ?? '',
            ],
            'alliance_leader_position',
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