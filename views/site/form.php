<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\Applicant $model */
/** @var app\models\Beneficiary[] $modelBeneficiaries */

use app\models\Applicant;
use app\models\Refregion;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use kartik\file\FileInput;
use Yii2\Extensions\DynamicForm\DynamicFormWidget;

$this->registerCssFile('@web/css/applicant-form.css');

$allianceType = Applicant::VOLUNTEER_DETAILS_REGISTRATION_TYPE_ALLIANCE;
$sectorialType = Applicant::VOLUNTEER_DETAILS_REGISTRATION_TYPE_SECTORIAL;
$organicType = Applicant::VOLUNTEER_DETAILS_REGISTRATION_TYPE_ONEMOVEMENT_ORGANIC;


$this->registerJs(<<<JS

(function () {
    var accordion = document.getElementById('applicationAccordion');
    var legalCheckbox = document.getElementById('legal-terms-check');
    var submitButton = document.getElementById('final-submit-btn');

    if (!accordion) {
        return;
    }

    var collapses = Array.prototype.slice.call(accordion.querySelectorAll('.accordion-collapse'));
    var headers = Array.prototype.slice.call(accordion.querySelectorAll('.accordion-button'));

    function openStep(index) {
        if (index < 0 || index >= collapses.length) {
            return;
        }

        collapses.forEach(function (collapse, i) {
            var isTarget = i === index;
            collapse.classList.toggle('show', isTarget);

            if (headers[i]) {
                headers[i].classList.toggle('collapsed', !isTarget);
                headers[i].setAttribute('aria-expanded', isTarget ? 'true' : 'false');
            }
        });

        var activeHeader = headers[index];
        if (activeHeader) {
            activeHeader.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    accordion.addEventListener('click', function (event) {
        var navButton = event.target.closest('[data-nav]');
        if (navButton) {
            event.preventDefault();
            var current = parseInt(navButton.getAttribute('data-current'), 10);
            if (Number.isNaN(current)) {
                return;
            }

            if (navButton.getAttribute('data-nav') === 'next') {
                openStep(current + 1);
            }

            if (navButton.getAttribute('data-nav') === 'prev') {
                openStep(current - 1);
            }
            return;
        }

        var headerButton = event.target.closest('.accordion-button[data-step-index]');
        if (headerButton) {
            event.preventDefault();
            var stepIndex = parseInt(headerButton.getAttribute('data-step-index'), 10);
            if (!Number.isNaN(stepIndex)) {
                openStep(stepIndex);
            }
        }
    });

    function syncSubmitState() {
        if (!legalCheckbox || !submitButton) {
            return;
        }
        submitButton.disabled = !legalCheckbox.checked;
    }

    if (legalCheckbox) {
        legalCheckbox.addEventListener('change', syncSubmitState);
        syncSubmitState();
    }

    openStep(0);
})();

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



// Calculate age based on birth date
document.getElementById('birth-date').addEventListener('change', function () {

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

        case '{$allianceType}':
            label.html('Alliance <span class="text-danger">*</span>');
            break;

        case '{$sectorialType}':
            label.html('Sectorial <span class="text-danger">*</span>');
            break;

        case '{$organicType}':
            label.html('One Movement Organic <span class="text-danger">*</span>');
            break;
    }

}

toggleGroup();

$('#registration-type-dropdown').on('change', toggleGroup);

JS);
?>


<div class="applicant-form-page">
    <div class="applicant-form-header">
        <h2>Volunteer Membership Application Form</h2>
        <p>Complete all sections below. Use Next and Previous to move through the application without reloading the page.</p>
    </div>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= Yii::$app->session->getFlash('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="applicant-form">
        <?php $form = ActiveForm::begin([
            'id' => 'applicant-form',
            'options' => [
                'enctype' => 'multipart/form-data',
            ],
            'enableClientValidation' => true,
            'enableAjaxValidation' => false,
        ]); ?>

        <div class="accordion application-accordion" id="applicationAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" aria-expanded="true" aria-controls="collapseOne" data-step-index="0">
                        <span class="step-badge">1</span>
                        <span class="step-title">Personal Information</span>
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-parent="#applicationAccordion">
                    <div class="accordion-body">
                        <p class="section-note">Provide your personal details exactly as they appear on your valid identification.</p>
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-12"><?= $form->field($model, 'personal_information_firstname')->textInput(['maxlength' => true, 'style' => 'text-transform: uppercase;'])->label('First Name <span class="text-danger">*</span>', ['encode' => false]) ?></div>
                            <div class="col-lg-3 col-md-6 col-12"><?= $form->field($model, 'personal_information_middlename')->textInput(['maxlength' => true, 'style' => 'text-transform: uppercase;'])->label('Middle Name') ?></div>
                            <div class="col-lg-3 col-md-6 col-12"><?= $form->field($model, 'personal_information_lastname')->textInput(['maxlength' => true, 'style' => 'text-transform: uppercase;'])->label('Last Name <span class="text-danger">*</span>', ['encode' => false]) ?></div>
                            <div class="col-lg-2 col-md-6 col-12"><?= $form->field($model, 'personal_information_extension_name')->dropDownList($model::optsPersonalInformationExtensionName(), ['prompt' => ''])->label('Extn. Name') ?></div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <?= $form->field($model, 'personal_information_birthday')->input('date', [
                                    'id' => 'birth-date',
                                ])->label('Date of Birth <span class="text-danger">*</span>', ['encode' => false]) ?>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12"><?= $form->field($model, 'personal_information_contact')->textInput(['maxlength' => true])->label('Contact <span class="text-danger">*</span>', ['encode' => false]) ?></div>
                            <div class="col-lg-4 col-md-6 col-12"><?= $form->field($model, 'personal_information_email')->textInput(['maxlength' => true, 'style' => 'text-transform: uppercase;'])->label('Email') ?></div>
                            <div class="col-lg-4 col-md-6 col-12"><?= $form->field($model, 'personal_information_gender')->dropDownList($model::optsPersonalInformationGender(), ['prompt' => ''])->label('Sex <span class="text-danger">*</span>', ['encode' => false]) ?></div>
                            <div class="col-lg-4 col-md-6 col-12"><?= $form->field($model, 'personal_information_civil_status')->dropDownList($model::optsPersonalInformationCivilStatus(), ['prompt' => ''])->label('Civil Status <span class="text-danger">*</span>', ['encode' => false]) ?></div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <?= $form->field($model, 'personal_information_age')->textInput([
                                    'readonly' => true,
                                    'id' => 'age',
                                ])->label('Age <span class="text-danger">*</span>', ['encode' => false]) ?>
                            </div>
                        </div>
                        <div class="step-actions step-actions-end">
                            <?= Html::button('Next', ['class' => 'btn btn-maroon btn-nav', 'type' => 'button', 'data-nav' => 'next', 'data-current' => 0]) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" aria-expanded="false" aria-controls="collapseTwo" data-step-index="1">
                        <span class="step-badge">2</span>
                        <span class="step-title">Address Details</span>
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-parent="#applicationAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
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
                                ); ?></div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <?= $form->field($model, 'address_details_province')->widget(DepDrop::class, [
                                    'type' => DepDrop::TYPE_SELECT2,
                                    'options' => [
                                        'id' => 'province-dropdown',
                                    ],
                                    'pluginOptions' => [
                                        'depends' => ['region-dropdown'],
                                        'placeholder' => '',
                                        'url' => Url::to(['/address/province-list']),
                                    ],
                                ])->label(
                                    'Province <span class="text-danger">*</span>',
                                    ['encode' => false]
                                ); ?></div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <?= $form->field($model, 'address_details_city_municipality')->widget(\kartik\depdrop\DepDrop::class, [
                                    'type' => \kartik\depdrop\DepDrop::TYPE_SELECT2,
                                    'options' => [
                                        'id' => 'city-dropdown',
                                    ],
                                    'pluginOptions' => [
                                        'depends' => ['province-dropdown'],
                                        'placeholder' => '',
                                        'url' => Url::to(['/address/city-list']),
                                    ],
                                ])->label(
                                    'City / Municipality <span class="text-danger">*</span>',
                                    ['encode' => false]
                                ); ?></div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <?= $form->field($model, 'address_details_brgy')->widget(\kartik\depdrop\DepDrop::class, [
                                    'type' => \kartik\depdrop\DepDrop::TYPE_SELECT2,
                                    'options' => [
                                        'id' => 'barangay-dropdown',
                                    ],
                                    'pluginOptions' => [
                                        'depends' => ['city-dropdown'],
                                        'placeholder' => '',
                                        'url' => Url::to(['/address/barangay-list']),
                                    ],
                                ])->label(
                                    'Barangay <span class="text-danger">*</span>',
                                    ['encode' => false]
                                ); ?></div>
                            <div class="col-12"><?= $form->field($model, 'address_details_district_street')->textInput(['maxlength' => true])->label('District No./Street/Purok <span class="text-danger">*</span>', ['encode' => false]) ?></div>
                        </div>
                        <div class="step-actions">
                            <?= Html::button('Previous', ['class' => 'btn btn-outline-maroon btn-nav', 'type' => 'button', 'data-nav' => 'prev', 'data-current' => 1]) ?>
                            <?= Html::button('Next', ['class' => 'btn btn-maroon btn-nav', 'type' => 'button', 'data-nav' => 'next', 'data-current' => 1]) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" aria-expanded="false" aria-controls="collapseThree" data-step-index="2">
                        <span class="step-badge">3</span>
                        <span class="step-title">Employment Information</span>
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-parent="#applicationAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-12"><?= $form->field($model, 'employment_information_occupation')->textInput(['maxlength' => true, 'style' => 'text-transform: uppercase;'])->label('Occupation <span class="text-danger">*</span>', ['encode' => false]) ?></div>
                            <div class="col-lg-4 col-md-6 col-12"><?= $form->field($model, 'employment_information_sector_of_employment')->dropDownList($model::optsEmploymentInformationSectorOfEmployment(), ['prompt' => ''])->label('Sector of Employment <span class="text-danger">*</span>', ['encode' => false]) ?></div>
                            <div class="col-lg-4 col-md-6 col-12"><?= $form->field($model, 'employment_information_salary')->input('number', ['min' => 0])->label('Salary <span class="text-danger">*</span>', ['encode' => false]) ?></div>
                        </div>
                        <div class="step-actions">
                            <?= Html::button('Previous', ['class' => 'btn btn-outline-maroon btn-nav', 'type' => 'button', 'data-nav' => 'prev', 'data-current' => 2]) ?>
                            <?= Html::button('Next', ['class' => 'btn btn-maroon btn-nav', 'type' => 'button', 'data-nav' => 'next', 'data-current' => 2]) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" aria-expanded="false" aria-controls="collapseFour" data-step-index="3">
                        <span class="step-badge">4</span>
                        <span class="step-title">Emergency Contact</span>
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-parent="#applicationAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-12"><?= $form->field($model, 'emergency_contact_fullname')->textInput(['maxlength' => true, 'style' => 'text-transform: uppercase;'])->label('Full Name <span class="text-danger">*</span>', ['encode' => false]) ?></div>
                            <div class="col-lg-4 col-md-6 col-12"><?= $form->field($model, 'emergency_contact_number')->textInput(['maxlength' => true])->label('Contact Number <span class="text-danger">*</span>', ['encode' => false]) ?></div>
                            <div class="col-lg-4 col-md-6 col-12"><?= $form->field($model, 'emergency_contact_address')->textInput(['maxlength' => true, 'style' => 'text-transform: uppercase;'])->label('Address <span class="text-danger">*</span>', ['encode' => false]) ?></div>
                        </div>
                        <div class="step-actions">
                            <?= Html::button('Previous', ['class' => 'btn btn-outline-maroon btn-nav', 'type' => 'button', 'data-nav' => 'prev', 'data-current' => 3]) ?>
                            <?= Html::button('Next', ['class' => 'btn btn-maroon btn-nav', 'type' => 'button', 'data-nav' => 'next', 'data-current' => 3]) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFive">
                    <button class="accordion-button collapsed" type="button" aria-expanded="false" aria-controls="collapseFive" data-step-index="4">
                        <span class="step-badge">5</span>
                        <span class="step-title">Volunteer Details</span>
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-parent="#applicationAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <?= $form->field($model, 'volunteer_details_registration_type')->widget(Select2::class, [
                                    'data' => $model::optsVolunteerDetailsRegistrationType(),
                                    'options' => [
                                        'placeholder' => '',
                                        'id' => 'registration-type-dropdown',
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],
                                ])->label('Registration Type <span class="text-danger">*</span>', ['encode' => false]) ?>
                            </div>

                            <div
                                class="col-lg-6 col-md-6 col-12"
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
                                    'Alliance <span class="text-danger">*</span>',
                                    ['encode' => false]
                                ) ?>

                            </div>
                        </div>
                        <div class="step-actions">
                            <?= Html::button('Previous', ['class' => 'btn btn-outline-maroon btn-nav', 'type' => 'button', 'data-nav' => 'prev', 'data-current' => 4]) ?>
                            <?= Html::button('Next', ['class' => 'btn btn-maroon btn-nav', 'type' => 'button', 'data-nav' => 'next', 'data-current' => 4]) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSix">
                    <button class="accordion-button collapsed" type="button" aria-expanded="false" aria-controls="collapseSix" data-step-index="5">
                        <span class="step-badge">6</span>
                        <span class="step-title">Endorser / Sponsor / Who Invited You</span>
                    </button>
                </h2>
                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-parent="#applicationAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-12"><?= $form->field($model, 'endorsement_sponsor_who_invite')->textInput(['maxlength' => true, 'style' => 'text-transform: uppercase;'])->label('Details <span class="text-danger">*</span>', ['encode' => false]) ?></div>
                        </div>
                        <div class="step-actions">
                            <?= Html::button('Previous', ['class' => 'btn btn-outline-maroon btn-nav', 'type' => 'button', 'data-nav' => 'prev', 'data-current' => 5]) ?>
                            <?= Html::button('Next', ['class' => 'btn btn-maroon btn-nav', 'type' => 'button', 'data-nav' => 'next', 'data-current' => 5]) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSeven">
                    <button class="accordion-button collapsed" type="button" aria-expanded="false" aria-controls="collapseSeven" data-step-index="6">
                        <span class="step-badge">7</span>
                        <span class="step-title">Document Verification Uplink</span>
                    </button>
                </h2>
                <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-parent="#applicationAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
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
                                    ],
                                ])->label('Picture ID <span class="text-danger">*</span>', ['encode' => false]) ?>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
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
                                    ],
                                ])->label('E-Signature <span class="text-danger">*</span>', ['encode' => false]) ?>
                            </div>
                        </div>
                        <div class="step-actions">
                            <?= Html::button('Previous', ['class' => 'btn btn-outline-maroon btn-nav', 'type' => 'button', 'data-nav' => 'prev', 'data-current' => 6]) ?>
                            <?= Html::button('Next', ['class' => 'btn btn-maroon btn-nav', 'type' => 'button', 'data-nav' => 'next', 'data-current' => 6]) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSix">
                    <button class="accordion-button collapsed" type="button" aria-expanded="false" aria-controls="collapseSix" data-step-index="7">
                        <span class="step-badge">8</span>
                        <span class="step-title">Beneficiaries</span>
                    </button>
                </h2>
                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-parent="#applicationAccordion">
                    <div class="accordion-body">

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

                                <strong>Beneficiaries</strong>

                                <button type="button" class="add-item btn btn-success btn-sm">
                                    <i class="fas fa-plus"></i>
                                    Add Beneficiary
                                </button>

                            </div>

                            <div class="card-body container-beneficiaries">

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

                        <div class="step-actions">
                            <?= Html::button('Previous', [
                                'class' => 'btn btn-outline-maroon btn-nav',
                                'type' => 'button',
                                'data-nav' => 'prev',
                                'data-current' => 7
                            ]) ?>

                            <?= Html::button('Next', [
                                'class' => 'btn btn-maroon btn-nav',
                                'type' => 'button',
                                'data-nav' => 'next',
                                'data-current' => 7
                            ]) ?>
                        </div>

                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingEight">
                    <button class="accordion-button collapsed" type="button" aria-expanded="false" aria-controls="collapseEight" data-step-index="8">
                        <span class="step-badge">9</span>
                        <span class="step-title">Submit Application</span>
                    </button>
                </h2>
                <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-parent="#applicationAccordion">
                    <div class="accordion-body">
                        <div class="form-check legal-confirmation">

                            <?= Html::checkbox('legal_terms_confirmation', false, [
                                'id' => 'legal-terms-check',
                                'class' => 'form-check-input',
                                'label' => 'I confirm that all information provided is true and accurate, and I agree to legal verification by the organization. <span class="text-danger">*</span>',
                                'labelOptions' => [
                                    'class' => 'form-check-label'
                                ],
                                'required' => true,
                                'uncheck' => null,
                            ]) ?>

                        </div>
                        <div class="step-actions step-actions-end">
                            <?= Html::submitButton('Submit Application', ['class' => 'btn btn-maroon btn-nav', 'id' => 'final-submit-btn']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>