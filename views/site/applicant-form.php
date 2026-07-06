<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Applicant $model */
/** @var ActiveForm $form */

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

.applicant-form .form-control {
    display: block;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    height: 42px;
    border-radius: 12px;
    border-color: #d8d8d8;
    font-size: 0.95rem;
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
CSS);

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
JS);
?>
<div class="applicant-form-page">
    <div class="applicant-form-header">
        <h2>Volunteer Membership Application Form</h2>
        <p>Complete all sections below. Use Next and Previous to move through the application without reloading the page.</p>
    </div>

    <div class="applicant-form">
        <?php $form = ActiveForm::begin(); ?>

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
                            <div class="col-lg-3 col-md-6 col-12"><?= $form->field($model, 'personal_information_firstname')->textInput(['maxlength' => true])->label('First Name') ?></div>
                            <div class="col-lg-3 col-md-6 col-12"><?= $form->field($model, 'personal_information_middlename')->textInput(['maxlength' => true])->label('Middle Name') ?></div>
                            <div class="col-lg-3 col-md-6 col-12"><?= $form->field($model, 'personal_information_lastname')->textInput(['maxlength' => true])->label('Last Name') ?></div>
                            <div class="col-lg-3 col-md-6 col-12"><?= $form->field($model, 'personal_information_extension_name')->dropDownList($model::optsPersonalInformationExtensionName(), ['prompt' => 'Select'])->label('Extn. Name') ?></div>
                            <div class="col-lg-6 col-md-6 col-12"><?= $form->field($model, 'personal_information_birthday')->input('date')->label('Birthday') ?></div>
                            <div class="col-lg-6 col-md-6 col-12"><?= $form->field($model, 'personal_information_contact')->textInput(['maxlength' => true])->label('Contact') ?></div>
                            <div class="col-lg-4 col-md-6 col-12"><?= $form->field($model, 'personal_information_gender')->dropDownList($model::optsPersonalInformationGender(), ['prompt' => 'Select'])->label('Sex') ?></div>
                            <div class="col-lg-4 col-md-6 col-12"><?= $form->field($model, 'personal_information_civil_status')->dropDownList($model::optsPersonalInformationCivilStatus(), ['prompt' => 'Select'])->label('Civil Status') ?></div>
                            <div class="col-lg-4 col-md-6 col-12"><?= $form->field($model, 'personal_information_age')->input('number', ['min' => 1, 'max' => 120])->label('Age') ?></div>
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
                            <div class="col-lg-6 col-md-6 col-12"><?= $form->field($model, 'address_details_region')->input('number')->label('Region') ?></div>
                            <div class="col-lg-6 col-md-6 col-12"><?= $form->field($model, 'address_details_province')->input('number')->label('Province') ?></div>
                            <div class="col-lg-6 col-md-6 col-12"><?= $form->field($model, 'address_details_city_municipality')->input('number')->label('City / Municipality') ?></div>
                            <div class="col-lg-6 col-md-6 col-12"><?= $form->field($model, 'address_details_brgy')->input('number')->label('Barangay') ?></div>
                            <div class="col-12"><?= $form->field($model, 'address_details_district_street')->textInput(['maxlength' => true])->label('District No./Street/Purok') ?></div>
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
                            <div class="col-lg-4 col-md-6 col-12"><?= $form->field($model, 'employment_information_occupation')->textInput(['maxlength' => true])->label('Occupation') ?></div>
                            <div class="col-lg-4 col-md-6 col-12"><?= $form->field($model, 'employment_information_sector_of_employment')->dropDownList($model::optsEmploymentInformationSectorOfEmployment(), ['prompt' => 'Select sector'])->label('Sector of Employment') ?></div>
                            <div class="col-lg-4 col-md-6 col-12"><?= $form->field($model, 'employment_information_salary')->input('number', ['min' => 0])->label('Salary') ?></div>
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
                            <div class="col-lg-4 col-md-6 col-12"><?= $form->field($model, 'emergency_contact_fullname')->textInput(['maxlength' => true])->label('Full Name') ?></div>
                            <div class="col-lg-4 col-md-6 col-12"><?= $form->field($model, 'emergency_contact_number')->textInput(['maxlength' => true])->label('Contact Number') ?></div>
                            <div class="col-lg-4 col-md-6 col-12"><?= $form->field($model, 'emergency_contact_address')->textInput(['maxlength' => true])->label('Address') ?></div>
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
                            <div class="col-lg-6 col-md-6 col-12"><?= $form->field($model, 'volunteer_details_registration_type')->dropDownList($model::optsVolunteerDetailsRegistrationType(), ['prompt' => 'Select registration type'])->label('Registration Type (Alliance or Individual Sectorial)') ?></div>
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
                        <span class="step-title">Endorsement / Sponsor / Who Invited You</span>
                    </button>
                </h2>
                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-parent="#applicationAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-12"><?= $form->field($model, 'endorsement_sponsor_who_invite')->textarea(['rows' => 3])->label('Details') ?></div>
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
                            <div class="col-lg-6 col-md-6 col-12"><?= $form->field($model, 'document_verification_uplink_id')->textInput(['maxlength' => true])->label('ID') ?></div>
                            <div class="col-lg-6 col-md-6 col-12"><?= $form->field($model, 'document_verification_uplink_signature')->textarea(['rows' => 3])->label('Digital Signature') ?></div>
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
                                'label' => 'I confirm that all information provided is true and accurate, and I agree to legal verification by the organization.',
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