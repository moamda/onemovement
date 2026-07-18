<?php

use app\models\Refregion;
use app\models\Applicant;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use Yii2\Extensions\DynamicForm\DynamicFormWidget;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * @var \yii\web\View $this
 * @var \app\models\Applicant $model
 * @var \app\models\Member $member
 * @var \yii\bootstrap4\ActiveForm $form
 */

$allianceType = Applicant::VOLUNTEER_DETAILS_REGISTRATION_TYPE_ALLIANCE;
$sectorialType = Applicant::VOLUNTEER_DETAILS_REGISTRATION_TYPE_SECTORIAL;
$organicType = Applicant::VOLUNTEER_DETAILS_REGISTRATION_TYPE_ONEMOVEMENT_ORGANIC;

?>

<div class="applicant-form">

    <?php $form = ActiveForm::begin([
        'id' => 'applicant-form',
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <p class="form-control-static">
                <label class="control-label">Member Status:</label> <?= $member->status ?>
            </p>
        </div>
        <div class="col-md-6">
            <p class="form-control-static">
                <label class="control-label">Member Since:</label> <?= Yii::$app->formatter->asDatetime($member->created_at) ?>
            </p>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Personal Information</h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4">
                    <?= $form->field($model, 'personal_information_firstname')->textInput(['maxlength' => true])->label('Firstname <span class="text-danger">*</span>', ['encode' => false]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'personal_information_lastname')->textInput(['maxlength' => true])->label('Lastname <span class="text-danger">*</span>', ['encode' => false]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'personal_information_middlename')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-2">
                    <?= $form->field($model, 'personal_information_extension_name')->dropDownList([
                        'Jr.' => 'Jr.',
                        'Sr.' => 'Sr.',
                        'I' => 'I',
                        'II' => 'II',
                        'III' => 'III',
                        'IV' => 'IV',
                        'V' => 'V',
                    ], ['prompt' => ''])->label('Extn. Name', ['encode' => false]) ?>
                </div>

            </div>

            <div class="row">

                <div class="col-md-3">
                    <?= $form->field($model, 'personal_information_gender')->dropDownList([
                        'MALE' => 'MALE',
                        'FEMALE' => 'FEMALE',
                        'OTHERS' => 'OTHERS',
                    ], ['prompt' => ''])->label('Gender <span class="text-danger">*</span>', ['encode' => false]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'personal_information_contact')->textInput(['maxlength' => true])->label('Contact <span class="text-danger">*</span>', ['encode' => false]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'personal_information_email')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'personal_information_birthday')->input('date', [
                        'id' => 'birth-date',
                    ])->label('Date of Birth <span class="text-danger">*</span>', ['encode' => false]) ?>
                </div>

            </div>

            <div class="row">

                <div class="col-md-3">
                    <?= $form->field($model, 'personal_information_age')->textInput([
                        'readonly' => true,
                        'id' => 'age',
                    ])->label('Age <span class="text-danger">*</span>', ['encode' => false]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'personal_information_civil_status')->dropDownList([
                        'SINGLE' => 'SINGLE',
                        'MARRIED' => 'MARRIED',
                        'WIDOWED' => 'WIDOWED',
                        'SEPARATED' => 'SEPARATED',
                    ], ['prompt' => ''])->label('Civil Status <span class="text-danger">*</span>', ['encode' => false]) ?>
                </div>

            </div>

        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Address Details</h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">
                    <?= $form->field($model, 'address_details_region')->widget(Select2::class, [
                        'data' => ArrayHelper::map(
                            Refregion::find()->orderBy('regDesc')->all(),
                            'psgcCode',
                            'regDesc'
                        ),
                        'options' => [
                            'placeholder' => '',
                            'id' => 'region-dropdown',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label(
                        'Region <span class="text-danger">*</span>',
                        ['encode' => false]
                    ); ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'address_details_province')->widget(DepDrop::class, [
                        'type' => DepDrop::TYPE_SELECT2,
                        'options' => [
                            'id' => 'province-dropdown',
                        ],
                        'pluginOptions' => [
                            'depends' => ['region-dropdown'],
                            'placeholder' => '',
                            'initialize' => true,
                            'url' => Url::to(['/address/province-list']),
                        ],
                    ])->label(
                        'Province <span class="text-danger">*</span>',
                        ['encode' => false]
                    ); ?>
                </div>
            </div>

            <div class="row">

                <div class="col-md-6">
                    <?= $form->field($model, 'address_details_city_municipality')->widget(\kartik\depdrop\DepDrop::class, [
                        'type' => \kartik\depdrop\DepDrop::TYPE_SELECT2,
                        'options' => [
                            'id' => 'city-dropdown',
                        ],
                        'pluginOptions' => [
                            'depends' => ['province-dropdown'],
                            'initialize' => true,
                            'placeholder' => '',
                            'url' => Url::to(['/address/city-list']),
                        ],
                    ])->label(
                        'City / Municipality <span class="text-danger">*</span>',
                        ['encode' => false]
                    ); ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'address_details_brgy')->widget(\kartik\depdrop\DepDrop::class, [
                        'type' => \kartik\depdrop\DepDrop::TYPE_SELECT2,
                        'options' => [
                            'id' => 'barangay-dropdown',
                        ],
                        'pluginOptions' => [
                            'depends' => ['city-dropdown'],
                            'placeholder' => '',
                            'initialize' => true,
                            'url' => Url::to(['/address/barangay-list']),
                        ],
                    ])->label(
                        'Barangay <span class="text-danger">*</span>',
                        ['encode' => false]
                    ); ?>
                </div>

            </div>

            <div class="row">

                <div class="col-md-12">
                    <?= $form->field($model, 'address_details_district_street')->textInput([
                        'maxlength' => true,
                    ])->label('District/Street <span class="text-danger">*</span>', ['encode' => false]) ?>
                </div>

            </div>

        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Employment Information</h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-5">
                    <?= $form->field($model, 'employment_information_occupation')->textInput([
                        'maxlength' => true,
                    ])->label('Occupation <span class="text-danger">*</span>', ['encode' => false]) ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'employment_information_sector_of_employment')->dropDownList([
                        'N/A' => 'N/A',
                        'PRIVATE' => 'PRIVATE',
                        'GOVERNMENT' => 'GOVERNMENT',
                    ], ['prompt' => ''])->label('Sector of Employment <span class="text-danger">*</span>', ['encode' => false]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'employment_information_salary')->textInput()->label('Salary <span class="text-danger">*</span>', ['encode' => false]) ?>
                </div>

            </div>

        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Emergency Contact</h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-5">
                    <?= $form->field($model, 'emergency_contact_fullname')->textInput([
                        'maxlength' => true,
                    ])->label('Full Name <span class="text-danger">*</span>', ['encode' => false]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'emergency_contact_number')->textInput([
                        'maxlength' => true,
                    ])->label('Contact Number <span class="text-danger">*</span>', ['encode' => false]) ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'emergency_contact_address')->textInput([
                        'maxlength' => true,
                    ])->label('Address <span class="text-danger">*</span>', ['encode' => false]) ?>
                </div>

            </div>

        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Volunteer Details</h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4">
                    <?= $form->field($model, 'volunteer_details_registration_type')->widget(Select2::class, [
                        'data' => $model::optsVolunteerDetailsRegistrationType(),
                        'options' => [
                            'placeholder' => 'Select Registration Type',
                            'id' => 'registration-type-dropdown',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label('Registration Type <span class="text-danger">*</span>', ['encode' => false]) ?>
                </div>

                <div class="col-md-4"
                    id="group-wrapper"
                    style="display:none;">

                    <?= $form->field($model, 'volunteer_details_group_name')->widget(DepDrop::class, [
                        'type' => DepDrop::TYPE_SELECT2,
                        'options' => [
                            'id' => 'group-dropdown',
                        ],
                        'pluginOptions' => [
                            'depends' => ['registration-type-dropdown'],
                            'placeholder' => '',
                            'url' => Url::to(['/applicant/group-list']),
                            'allowClear' => true,
                            'initialize' => true,
                        ],
                    ])->label(
                        'Group Name <span class="text-danger">*</span>',
                        ['encode' => false]
                    ) ?>

                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'endorsement_sponsor_who_invite')->textInput([
                        'maxlength' => true,
                    ])->label('Sponsor / Who Invited You <span class="text-danger">*</span>', ['encode' => false]) ?>
                </div>

            </div>

        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Document Verification</h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <?= $form->field($model, 'document_verification_uplink_id')->widget(\kartik\file\FileInput::class, [
                        'options' => [
                            'accept' => 'image/*',
                        ],
                        'pluginOptions' => [
                            'allowedFileExtensions' => ['jpg', 'jpeg', 'png'],
                            'maxFileSize' => 2048,
                            'showUpload' => false,
                            'showCancel' => false,
                            'showRemove' => false,
                            'showPreview' => true,
                            'showZoom' => true,
                            'overwriteInitial' => true,
                            'browseLabel' => 'Upload',

                            'initialPreview' => [
                                Url::to([
                                    'applicant/view-id',
                                    'id' => $model->id,
                                ])
                            ],
                            'initialPreviewAsData' => true,
                        ],
                    ])->label('Picture ID <span class="text-danger">*</span>', ['encode' => false]) ?>

                </div>

                <div class="col-md-6">

                    <?= $form->field($model, 'document_verification_uplink_signature')->widget(\kartik\file\FileInput::class, [
                        'options' => [
                            'accept' => 'image/*',
                        ],
                        'pluginOptions' => [
                            'allowedFileExtensions' => ['jpg', 'jpeg', 'png'],
                            'maxFileSize' => 2048,
                            'showUpload' => false,
                            'showCancel' => false,
                            'showRemove' => false,
                            'showPreview' => true,
                            'showZoom' => true,
                            'overwriteInitial' => true,
                            'browseLabel' => 'Upload',



                            'initialPreview' => [
                                Url::to([
                                    'applicant/view-signature',
                                    'id' => $model->id,
                                ])
                            ],
                            'initialPreviewAsData' => true,
                        ],
                    ])->label('E-Signature <span class="text-danger">*</span>', ['encode' => false]) ?>

                </div>

            </div>

        </div>
    </div>

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-beneficiaries',
        'widgetItem' => '.beneficiary-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-item',
        'deleteButton' => '.remove-item',
        'model' => $modelBeneficiaries[0],
        'formId' => 'applicant-form',
        'formFields' => [
            'beneficiary_lastname',
            'beneficiary_firstname',
            'beneficiary_middlename',
            'beneficiary_extension_name',
            'beneficiary_relationship',
            'beneficiary_birthdate',
            'beneficiary_gender',
            'beneficiary_civil_status',
        ],
    ]); ?>

    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Beneficiaries</h5>

            <button type="button" class="add-item btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Add Beneficiary
            </button>
        </div>

        <div class="card-body">
            <div class="container-beneficiaries">

                <?php foreach ($modelBeneficiaries as $index => $modelBeneficiary): ?>
                    <?= $this->render('/applicant/_beneficiary', [
                        'form' => $form,
                        'model' => $modelBeneficiary,
                        'index' => $index,
                    ]) ?>
                <?php endforeach; ?>

            </div>

        </div>
        <?php DynamicFormWidget::end(); ?>
    </div>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>

<script>
    // Calculate age based on birth date
    document.getElementById('birth-date').addEventListener('change', function() {

        const birthDate = new Date(this.value);

        if (isNaN(birthDate)) {
            document.getElementById('age').value = '';
            return;
        }

        const today = new Date();

        let age = today.getFullYear() - birthDate.getFullYear();

        const monthDiff = today.getMonth() - birthDate.getMonth();

        if (
            monthDiff < 0 ||
            (monthDiff === 0 && today.getDate() < birthDate.getDate())
        ) {
            age--;
        }

        document.getElementById('age').value = age;
        // end of age calculation
    });

    // dynamic beneficiaries numbering
    function updateBeneficiaryNumbers() {
        $('.dynamicform_wrapper .beneficiary-item').each(function(index) {
            $(this).find('.beneficiary-number').text(index + 1);
        });
    }

    $('.dynamicform_wrapper').on('afterInsert', function() {
        updateBeneficiaryNumbers();
    });

    $('.dynamicform_wrapper').on('afterDelete', function() {
        updateBeneficiaryNumbers();
    });

    updateBeneficiaryNumbers();

    // ========================================
    // toggle group dropdown based on registration type selection
    // ========================================

    function toggleGroup() {

        const registrationType = $('#registration-type-dropdown').val();

        if (!registrationType) {

            $('#group-wrapper').hide();

            $('#group-dropdown').val(null).trigger('change');

            return;
        }

        $('#group-wrapper').show();

        const label = $('#group-wrapper label');

        switch (registrationType) {

            case '<?= $allianceType ?>':
                label.html('Alliance <span class="text-danger">*</span>');
                break;

            case '<?= $sectorialType ?>':
                label.html('Sectorial <span class="text-danger">*</span>');
                break;

            case '<?= $organicType ?>':
                label.html('One Movement Organic <span class="text-danger">*</span>');
                break;
        }

    }

    toggleGroup();

    $('#registration-type-dropdown').on('change', toggleGroup);
</script>

<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
        margin-bottom: 20px;

    }

    .card-header {
        font-weight: 600;
        color: #ffffff;
        background-color: #941818;
        border-color: #941818;
    }

    .img-thumbnail {
        border-radius: 8px;
    }

    .badge {
        border-radius: 30px;
    }
</style>