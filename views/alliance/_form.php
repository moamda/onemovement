<?php

use app\modules\admin\models\Profile;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Alliance */
/* @var $form yii\widgets\ActiveForm */

$leaders = ArrayHelper::map(
    Profile::find()
        ->joinWith('user')
        ->where(['user.status' => 10]) // palitan depende sa active value
        ->orderBy([
            'last_name' => SORT_ASC,
            'first_name' => SORT_ASC,
        ])
        ->all(),
    'user_id',
    function ($profile) {
        return trim(
            $profile->last_name . ', ' .
                $profile->first_name . ' ' .
                $profile->middle_name
        );
    }
);
?>

<div class="alliance-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'organization')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'area_of_ceverage')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'alliance_leader_user_id')->widget(Select2::class, [
        'data' => array_map(fn($name) => mb_strtoupper($name, 'UTF-8'), $leaders),
        'options' => [
            'placeholder' => 'Select Leader...',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'alliance_leader_contact')->textInput() ?>

    <?= $form->field($model, 'alliance_leader_position')->widget(Select2::class, [
        'data' => $model::optsAllianceLeaderPosition(),
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <!-- <= $form->field($model, 'status')->widget(Select2::class, [
        'data' => $model::optsStatus(),
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?> -->

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>