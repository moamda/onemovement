<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Member */
?>
<div class="member-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'applicant_id',
            'alliance_id',
            'created_at',
        ],
    ]) ?>

</div>
