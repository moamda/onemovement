<?php
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Applicant */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="applicant-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->dropDownList([ 'PENDING' => 'PENDING', 'REJECTED' => 'REJECTED', 'APPROVED' => 'APPROVED', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'personal_information_firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'personal_information_lastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'personal_information_middlename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'personal_information_extension_name')->dropDownList([ 'Jr.' => 'Jr.', 'Sr.' => 'Sr.', 'I' => 'I', 'II' => 'II', 'III' => 'III', 'IV' => 'IV', 'V' => 'V', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'personal_information_gender')->dropDownList([ 'MALE' => 'MALE', 'FEMALE' => 'FEMALE', 'OTHERS' => 'OTHERS', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'personal_information_contact')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'personal_information_birthday')->textInput() ?>

    <?= $form->field($model, 'personal_information_age')->textInput() ?>

    <?= $form->field($model, 'personal_information_civil_status')->dropDownList([ 'SINGLE' => 'SINGLE', 'MARRIED' => 'MARRIED', 'WIDOWED' => 'WIDOWED', 'SEPARATED' => 'SEPARATED', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'address_details_region')->textInput() ?>

    <?= $form->field($model, 'address_details_province')->textInput() ?>

    <?= $form->field($model, 'address_details_city_municipality')->textInput() ?>

    <?= $form->field($model, 'address_details_brgy')->textInput() ?>

    <?= $form->field($model, 'address_details_district_street')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'employment_information_occupation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'employment_information_sector_of_employment')->dropDownList([ 'PRIVATE' => 'PRIVATE', 'GOVERNMENT' => 'GOVERNMENT', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'employment_information_salary')->textInput() ?>

    <?= $form->field($model, 'emergency_contact_fullname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emergency_contact_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emergency_contact_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'volunteer_details_registration_type')->dropDownList([ 'ALLIANCE' => 'ALLIANCE', 'INDIVIDUAL SECTORIAL' => 'INDIVIDUAL SECTORIAL', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'endorsement_sponsor_who_invite')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'document_verification_uplink_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'document_verification_uplink_signature')->textInput(['maxlength' => true]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
