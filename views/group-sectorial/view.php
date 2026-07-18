<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\GroupSectorial */
?>
<div class="group-sectorial-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'group_name',
            'group_description',
            'group_leader_user_id',
            'group_leader_contact',
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