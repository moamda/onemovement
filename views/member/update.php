<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Member */
?>
<div class="member-update">

    <?= $this->render('_form', [
        'model' => $model,
        'member' => $member,
        'modelBeneficiaries' => $modelBeneficiaries,
    ]) ?>

</div>