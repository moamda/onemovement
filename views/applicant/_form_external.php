<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

?>

<div class="applicant-form">

    <?php $form = ActiveForm::begin([
        'id' => 'applicant-form',
    ]); ?>

    <div class="bs-stepper">

        <!-- Step Header -->
        <div class="bs-stepper-header" role="tablist">

            <div class="step" data-target="#personal-part">
                <button type="button" class="step-trigger">
                    <span class="bs-stepper-circle">1</span>
                    <span class="bs-stepper-label">Personal</span>
                </button>
            </div>

        </div>

        <!-- Step Content -->
        <div class="bs-stepper-content mt-4">

            <div id="personal-part" class="content active dstepper-block">

                <div class="row">

                    <div class="col-md-3">
                        <?= $form->field($model, 'personal_information_firstname')
                            ->textInput([
                                'maxlength' => true,
                                'style' => 'text-transform:uppercase'
                            ]) ?>
                    </div>

                    <div class="col-md-3">
                        <?= $form->field($model, 'personal_information_middlename')
                            ->textInput([
                                'maxlength' => true,
                                'style' => 'text-transform:uppercase'
                            ]) ?>
                    </div>

                    <div class="col-md-3">
                        <?= $form->field($model, 'personal_information_lastname')
                            ->textInput([
                                'maxlength' => true,
                                'style' => 'text-transform:uppercase'
                            ]) ?>
                    </div>

                    <div class="col-md-3">

                        <label>Extension Name</label>

                        <input
                            type="text"
                            class="form-control"
                            placeholder="Jr., Sr., III">

                    </div>

                    <div class="col-md-4">

                        <?= $form->field($model, 'personal_information_birthday')
                            ->input('date') ?>

                    </div>

                    <div class="col-md-4">

                        <?= $form->field($model, 'personal_information_gender')
                            ->dropDownList([
                                'male' => 'Male',
                                'female' => 'Female',
                                'others' => 'Others',
                            ], [
                                'prompt' => '-- Select --'
                            ]) ?>

                    </div>

                    <div class="col-md-4">

                        <label>Civil Status</label>

                        <select class="form-control">

                            <option value="">-- Select --</option>
                            <option>Single</option>
                            <option>Married</option>
                            <option>Widowed</option>
                            <option>Separated</option>

                        </select>

                    </div>

                    <div class="col-md-6">

                        <?= $form->field($model, 'personal_information_contact')
                            ->textInput([
                                'maxlength' => true
                            ]) ?>

                    </div>

                    <div class="col-md-6">

                        <label>Age</label>

                        <input
                            type="text"
                            id="age"
                            class="form-control"
                            readonly>

                    </div>

                </div>

                <hr>

                <div class="text-right">

                    <button
                        type="button"
                        class="btn btn-primary"
                        id="nextStep">

                        Next →
                    </button>

                </div>

            </div>

        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$this->registerJs("
var stepper = new Stepper(document.querySelector('.bs-stepper'));

$('#applicant-personal_information_birthday').change(function(){

    let birth = new Date($(this).val());

    let today = new Date();

    let age = today.getFullYear() - birth.getFullYear();

    let m = today.getMonth() - birth.getMonth();

    if(m < 0 || (m === 0 && today.getDate() < birth.getDate())){
        age--;
    }

    $('#age').val(age);

});

$('#nextStep').click(function(){

    stepper.next();

});
");
?>