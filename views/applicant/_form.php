<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Applicant */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="applicant-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true, 'style' => 'text-transform: uppercase;']) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true, 'style' => 'text-transform: uppercase;']) ?>

    <?= $form->field($model, 'middlename')->textInput(['maxlength' => true, 'style' => 'text-transform: uppercase;']) ?>

    <?= $form->field($model, 'gender')->dropDownList(['male' => 'Male', 'female' => 'Female', 'others' => 'Others',], ['prompt' => '']) ?>

    <?= $form->field($model, 'contact')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthday')->input('date') ?>


    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>