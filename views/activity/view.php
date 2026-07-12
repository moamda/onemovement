<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Activity */
?>
<div class="activity-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'activity_name',
        ],
    ]) ?>

</div>
