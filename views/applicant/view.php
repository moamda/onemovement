<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Applicant */
?>
<div class="applicant-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'firstname',
            'lastname',
            'middlename',
            'gender',
            'contact',
            'birthday',
        ],
    ]) ?>

</div>
