<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Applicant */
?>
<div class="applicant-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelBeneficiaries' => $modelBeneficiaries,
    ]) ?>

</div>