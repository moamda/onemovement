<?php

use yii\helpers\Html;
use app\modules\admin\models\Profile;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\GroupSectorial */
/* @var $form yii\bootstrap4\ActiveForm */

$leaders = ArrayHelper::map(
    Profile::find()
        ->joinWith('user')
        ->where(['user.status' => 10]) 
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



<div class="group-sectorial-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'group_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'group_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'group_leader_user_id')->widget(Select2::class, [
        'data' => array_map(fn($name) => mb_strtoupper($name, 'UTF-8'), $leaders),
        'options' => [
            'placeholder' => 'Select Leader...',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'group_leader_contact')->textInput() ?>


    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>