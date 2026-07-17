<?php

use yii\helpers\Html;

/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\Beneficiary */
/* @var $index integer */

?>

<div class="beneficiary-item card mb-3">

    <div class="card-header d-flex justify-content-between align-items-center">

        <strong>
            Beneficiary <span class="beneficiary-number"><?= $index + 1 ?></span>
        </strong>

        <button type="button" class="remove-item btn btn-sm btn-danger">
            <i class="fas fa-trash"></i>
        </button>

    </div>

    <div class="card-body">

        <?php
        // kailangan ito para sa update
        if (!$model->isNewRecord) {
            echo Html::activeHiddenInput($model, "[{$index}]id");
        }
        ?>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, "[{$index}]beneficiary_firstname")
                    ->textInput(['maxlength' => true, 'style' => 'text-transform: uppercase;'])->label('First Name <span class="text-danger">*</span>', ['encode' => false]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, "[{$index}]beneficiary_lastname")
                    ->textInput(['maxlength' => true, 'style' => 'text-transform: uppercase;'])->label('Last Name <span class="text-danger">*</span>', ['encode' => false]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, "[{$index}]beneficiary_middlename")
                    ->textInput(['maxlength' => true, 'style' => 'text-transform: uppercase;'])->label('Middle Name', ['encode' => false]) ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($model, "[{$index}]beneficiary_extension_name")->dropDownList($model::optsBeneficiaryExtensionName(), ['prompt' => ''])->label('Extn. Name') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, "[{$index}]beneficiary_relationship")
                    ->textInput(['maxlength' => true, 'style' => 'text-transform: uppercase;'])->label('Relationship <span class="text-danger">*</span>', ['encode' => false]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, "[{$index}]beneficiary_birthdate")->input('date')->label('Date of Birth <span class="text-danger">*</span>', ['encode' => false]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, "[{$index}]beneficiary_gender")->dropDownList($model::optsBeneficiaryGender(), ['prompt' => ''])->label('Gender <span class="text-danger">*</span>', ['encode' => false]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, "[{$index}]beneficiary_civil_status")->dropDownList($model::optsBeneficiaryCivilStatus(), ['prompt' => ''])->label('Civil Status <span class="text-danger">*</span>', ['encode' => false]) ?>
            </div>

        </div>

    </div>

</div>