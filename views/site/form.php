<?php

use app\models\Applicant;
use app\models\Refregion;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use kartik\file\FileInput;

$this->registerCss(<<<CSS
html {
    scrollbar-gutter: stable;
}

.applicant-form-page {
    max-width: 980px;
    margin: 24px auto 36px;
    padding: 0 14px;
    box-sizing: border-box;
}

.applicant-form,
.application-accordion,
.application-accordion .accordion-item,
.application-accordion .accordion-collapse,
.application-accordion .accordion-body {
    width: 100%;
    box-sizing: border-box;
}

.applicant-form-header {
    background: linear-gradient(140deg, #ffffff 0%, #f9f2f2 100%);
    border: 1px solid #e9e9e9;
    border-radius: 14px;
    padding: 22px;
    margin-bottom: 18px;
    box-shadow: 0 8px 20px rgba(20, 20, 20, 0.05);
}

.applicant-form-header h2 {
    margin: 0 0 4px;
    font-size: 1.65rem;
    color: #1e1e1e;
    font-weight: 700;
}

.applicant-form-header p {
    margin: 0;
    color: #5d5d5d;
}

.application-accordion .accordion-item {
    border: 1px solid #e8e8e8;
    border-radius: 14px;
    overflow: hidden;
    margin-bottom: 14px;
    background: #ffffff;
    box-shadow: 0 8px 20px rgba(28, 28, 28, 0.05);
}

.application-accordion .accordion-header {
    margin: 0;
}

.application-accordion .accordion-button {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 1rem 1.1rem;
    background-color: #ffffff;
    box-shadow: none;
    border: 0;
    color: #1e1e1e;
    font-weight: 700;
    font-size: 1rem;
}

.application-accordion .accordion-button:not(.collapsed) {
    color: #1e1e1e;
    background-color: #ffffff;
    box-shadow: none;
}

.application-accordion .accordion-button:focus {
    box-shadow: 0 0 0 0.2rem rgba(148, 24, 24, 0.15);
}

.application-accordion .accordion-body {
    padding: 0 1.1rem 1.1rem;
}

.application-accordion .accordion-body > .section-note,
.application-accordion .accordion-body > .row,
.application-accordion .accordion-body > .legal-confirmation,
.application-accordion .accordion-body > .step-actions {
    max-width: 860px;
    margin-left: auto;
    margin-right: auto;
}

.application-accordion .accordion-body > .row {
    margin-left: 0;
    margin-right: 0;
}

.step-badge {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #941818;
    color: #ffffff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
}

.step-title {
    margin: 0;
    color: #1f1f1f;
    font-size: 1rem;
}

.section-note {
    color: #6a6a6a;
    font-size: 0.92rem;
    margin-bottom: 10px;
}

.applicant-form .form-group {
    margin-bottom: 1rem;
}

/* ==========================================
   Universal Form Style
========================================== */

.applicant-form .form-control,
.applicant-form .custom-select {
    display: block;
    width: 100%;
    height: 46px;
    padding: .55rem .95rem;
    font-size: .95rem;
    color: #495057;
    background: #fff;
    border: 1px solid #d8d8d8;
    border-radius: 12px;
    transition: all .2s ease;
    box-shadow: none;
}

.applicant-form textarea.form-control{
    min-height:120px;
    height:auto;
    resize:vertical;
}

.applicant-form .form-control:focus,
.applicant-form .custom-select:focus{
    border-color:#941818;
    box-shadow:0 0 0 .2rem rgba(148,24,24,.15);
}

.applicant-form textarea.form-control {
    min-height: 100px;
    height: auto;
}

.step-actions {
    border-top: 1px solid #ececec;
    margin-top: 4px;
    padding-top: 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
}

.step-actions.step-actions-end {
    justify-content: flex-end;
}

.btn-nav {
    min-width: 122px;
    border-radius: 999px;
    font-weight: 600;
}

.btn-maroon {
    color: #ffffff;
    background-color: #941818;
    border-color: #941818;
}

.btn-maroon:hover,
.btn-maroon:focus {
    color: #ffffff;
    background-color: #7f1212;
    border-color: #7f1212;
}

.btn-maroon:disabled {
    color: #ffffff;
    background-color: #b06d6d;
    border-color: #b06d6d;
}

.btn-outline-maroon {
    color: #941818;
    border-color: #941818;
    background: #ffffff;
}

.btn-outline-maroon:hover,
.btn-outline-maroon:focus {
    color: #ffffff;
    background: #941818;
    border-color: #941818;
}

.legal-confirmation {
    border: 1px solid #ead6d6;
    background: #fcf8f8;
    border-radius: 12px;
    padding: 12px 14px;
    margin-bottom: 12px;
}

.legal-confirmation .custom-control-label {
    color: #4b4b4b;
    font-weight: 600;
}

@media (max-width: 768px) {
    .applicant-form-header h2 {
        font-size: 1.35rem;
    }

    .step-actions {
        flex-wrap: wrap;
    }

    .step-actions .btn {
        width: 100%;
    }
}

.legal-confirmation{
    margin:25px 0;
}

.legal-confirmation .form-check{
    display:flex;
    align-items:flex-start;
    gap:12px;
}

.legal-confirmation .form-check-input{
    margin-top:4px;
    cursor:pointer;
    flex-shrink:0;
}

.legal-confirmation .form-check-label{
    cursor:pointer;
    line-height:1.6;
    color:#444;
    font-size:15px;
}

/* Validation */
.applicant-form .has-error .form-control,
.applicant-form .has-error .select2-selection--single,
.applicant-form .has-error .file-caption,
.applicant-form .form-control.is-invalid{
    border-color:#dc3545 !important;
}

.applicant-form .help-block,
.applicant-form .invalid-feedback{
    display:block;
    color:#dc3545;
    margin-top:5px;
    font-size:.85rem;
}

.applicant-form .help-block,
.applicant-form .invalid-feedback {
    color: #dc3545 !important;
    display: block;
    margin-top: 5px;
    font-size: 0.875rem;
}

/* ===========================
   Select2 - Match Form Control
   =========================== */

.select2-container {
    width: 100% !important;
}

.select2-container .select2-selection--single {
    height: 42px !important;
    border: 1px solid #d8d8d8 !important;
    border-radius: 12px !important;
    background: #fff !important;
    display: flex !important;
    align-items: center;
    overflow: hidden;
    box-shadow: none !important;
}

.select2-container .select2-selection__rendered {
    line-height: normal !important;
    padding-left: 14px !important;
    padding-right: 35px !important;
    color: #495057 !important;
    font-size: .95rem;
}

.select2-container .select2-selection__arrow {
    width: 42px !important;
    height: 40px !important;
    border-left: 1px solid #d8d8d8;
}

.select2-container--focus .select2-selection--single,
.select2-container--open .select2-selection--single {
    border-color: #941818 !important;
    box-shadow: 0 0 0 .2rem rgba(148,24,24,.15) !important;
}

.select2-dropdown {
    border-radius: 12px !important;
    overflow: hidden;
}

/* ===========================
   Select2 / DepDrop Theme
   =========================== */

/* Border kapag naka-focus o open */
.select2-container--focus .select2-selection--single,
.select2-container--open .select2-selection--single {
    border-color: #941818 !important;
    box-shadow: 0 0 0 .2rem rgba(148,24,24,.15) !important;
}

/* Dropdown */
.select2-dropdown {
    border: 1px solid #941818 !important;
    border-radius: 12px !important;
    overflow: hidden;
}

/* Search box sa dropdown */
.select2-search__field {
    border: 1px solid #d8d8d8 !important;
    border-radius: 8px !important;
}

.select2-search__field:focus {
    border-color: #941818 !important;
    box-shadow: 0 0 0 .15rem rgba(148,24,24,.15) !important;
    outline: none !important;
}

/* Hover ng option */
.select2-results__option--highlighted {
    background: #941818 !important;
    color: #fff !important;
}

/* Selected option */
.select2-results__option[aria-selected="true"] {
    background: #f8eaea !important;
    color: #941818 !important;
    font-weight: 600;
}

/* Placeholder */
.select2-selection__placeholder {
    color: #888 !important;
}

/* Arrow color */
.select2-selection__arrow b {
    border-top-color: #941818 !important;
}

/* Clear (x) button */
.select2-selection__clear {
    color: #941818 !important;
    font-weight: bold;
}

.select2-selection__clear:hover {
    color: #7a1111 !important;
}

/* ==========================================
   Kartik FileInput
========================================== */

.file-input .btn{
    border-radius:12px;
}

.file-input .input-group,
.file-input .file-caption-main{
    display:flex;
    width:100%;
    flex-wrap:nowrap;
    align-items:stretch;
    gap:0;
}

.file-input .file-caption{
    width:auto !important;
    min-width:0;
    height:46px !important;
    border-radius:12px 0 0 12px !important;
    border:1px solid #d8d8d8 !important;
    box-shadow:none !important;
    flex:1;
}

.file-input .input-group-btn,
.file-input .btn-file{
    border-radius:12px 12px 12px 12px !important;
    background:#941818;
    border-color:#941818;
    color:#fff;
    flex-shrink:0;
    white-space:nowrap;
}

.file-input .fileinput-cancel,
.file-input .fileinput-remove,
.file-input .fileinput-upload + .fileinput-cancel,
.file-input .fileinput-remove + .fileinput-cancel{
    display:none !important;
}

.file-input .input-group .btn-file,
.file-input .input-group .file-caption,
.file-input .file-caption-main .btn-file,
.file-input .file-caption-main .file-caption{
    border-radius:12px !important;
}

.file-input .input-group .file-caption,
.file-input .file-caption-main .file-caption{
    border-top-right-radius:0 !important;
    border-bottom-right-radius:0 !important;
}

.file-input .input-group .btn-file,
.file-input .file-caption-main .btn-file{
    border-top-left-radius:0 !important;
    border-bottom-left-radius:0 !important;
}

.file-input .btn-file:hover{
    background:#7f1212;
    border-color:#7f1212;
}

.file-preview{
    border:1px solid #e6e6e6;
    border-radius:12px;
    padding:10px;
    box-shadow:none;
}

.file-drop-zone{
    border:none;
    margin:0;
    padding:0;
}

.file-preview-frame{
    border-radius:10px;
    border:1px solid #eee;
    box-shadow:none;
}
CSS);


$allianceType = Applicant::VOLUNTEER_DETAILS_REGISTRATION_TYPE_ALLIANCE;


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
// Show / Hide Alliance Group
// ========================================

function toggleAllianceGroup() {

    let registrationType = $('#registration-type-dropdown').val();

    if (registrationType == '{$allianceType}') {

        $('#alliance-group-wrapper').slideDown(250);

    } else {

        $('#alliance-group-wrapper').slideUp(250);

        $('#alliance-dropdown')
            .val(null)
            .trigger('change');

    }

}

// Run once on page load
toggleAllianceGroup();

// Run every time registration changes
$('#registration-type-dropdown').on('change', function () {
    toggleAllianceGroup();
});

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
                            <div class="col-lg-6 col-md-6 col-12"><?= $form->field($model, 'address_details_region')->widget(Select2::class, [
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
                            <div class="col-lg-6 col-md-6 col-12"><?= $form->field($model, 'address_details_province')->widget(DepDrop::class, [
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
                            <div class="col-lg-6 col-md-6 col-12"><?= $form->field($model, 'address_details_city_municipality')->widget(\kartik\depdrop\DepDrop::class, [
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
                            <div class="col-lg-6 col-md-6 col-12"><?= $form->field($model, 'address_details_brgy')->widget(\kartik\depdrop\DepDrop::class, [
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
                                        'placeholder' => 'Select Registration Type',
                                        'id' => 'registration-type-dropdown',
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],
                                ])->label('Registration Type <span class="text-danger">*</span>', ['encode' => false]) ?>
                            </div>

                            <div
                                class="col-lg-6 col-md-6 col-12"
                                id="alliance-group-wrapper"
                                style="display:none;">

                                <?= $form->field($model, 'volunteer_details_group_name')->widget(DepDrop::class, [
                                    'type' => DepDrop::TYPE_SELECT2,
                                    'options' => [
                                        'id' => 'alliance-dropdown',
                                    ],
                                    'pluginOptions' => [
                                        'depends' => ['registration-type-dropdown'],
                                        'placeholder' => 'Select Alliance',
                                        'url' => Url::to(['/alliance/alliance-list']),
                                        'allowClear' => true,
                                    ],
                                ])->label(
                                    'Alliance <span class="text-danger">*</span>',
                                    ['encode' => false]
                                ) ?>

                            </div>

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
                                ])->label('Government ID <span class="text-danger">*</span>', ['encode' => false]) ?>
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
                <h2 class="accordion-header" id="headingEight">
                    <button class="accordion-button collapsed" type="button" aria-expanded="false" aria-controls="collapseEight" data-step-index="7">
                        <span class="step-badge">8</span>
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