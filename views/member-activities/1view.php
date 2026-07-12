<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MemberActivity */
?>
<div class="member-activity-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'member_id',
            'activity_id',
        ],
    ]) ?>

</div>
