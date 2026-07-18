<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\GroupOrganic */
?>
<div class="group-organic-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'group_name',
            'group_description',
            'group_leader_user_id',
            'group_leader_contact',
            'created_at',
        ],
    ]) ?>

</div>
