<?php

/** @var yii\web\View $this */
/** @var app\models\LeadForm $model */

use app\models\Applicant;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
?>
<!-- ===================================================
     LEAD CAPTURE FORM SECTION
     =================================================== -->
<section id="contact" class="lp-section lp-section-dark">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-5 mb-lg-0" data-aos="fade-right">
                <span class="lp-section-badge lp-badge-light">Membership Application</span>
                <h2 class="lp-section-title lp-title-light mt-2">
                    Join One Movement <span class="lp-text-gradient">Become Part of a Community That Serves</span>
                </h2>
                <p class="lp-section-subtitle lp-subtitle-light mt-3">
                    Complete the membership application form below. Our team will review your application, and once approved, you'll officially become a One Movement member.
                </p>
                <div class="lp-contact-info mt-5">
                    <div class="lp-ci-item d-flex mb-3">
                        <div class="lp-ci-icon me-3">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                            </svg>
                        </div>
                        <div>
                            <div class="lp-ci-label">Email Us</div>
                            <div class="lp-ci-value">info@onemovement.org</div>
                        </div>
                    </div>
                    <div class="lp-ci-item d-flex mb-3">
                        <div class="lp-ci-icon me-3">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" />
                            </svg>
                        </div>
                        <div>
                            <div class="lp-ci-label">Call / Viber / WhatsApp</div>
                            <div class="lp-ci-value">+63 XXX XXX XXXX</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7" data-aos="fade-left" data-aos-delay="100">
                <div class="lp-form-card">
                    <?php if (Yii::$app->session->hasFlash('leadSubmitted')): ?>
                        <div class="lp-form-success text-center py-5">
                            <div class="lp-success-icon mb-4">&#127881;</div>
                            <h4 class="lp-success-title">Thank You! Application Received!</h4>
                            <p class="lp-success-text">
                                We'll review your application and get back to you within the day.
                            </p>
                        </div>
                    <?php else: ?>
                        <h4 class="lp-form-title mb-1">Membership Application Form</h4>
                        <p class="lp-form-sub mb-4">Please provide accurate information when completing your application.</p>

                        <?php $form = ActiveForm::begin([
                            'id'      => 'applicant',
                            'action'  => ['/site/index'],
                            'method'  => 'post',
                            'options' => ['class' => 'lp-form', 'novalidate' => true],
                            'fieldConfig' => [
                                'template'     => "{label}\n{input}\n{error}",
                                'labelOptions' => ['class' => 'lp-form-label'],
                                'inputOptions' => ['class' => 'form-control lp-form-control'],
                                'errorOptions' => ['class' => 'invalid-feedback d-block'],
                            ],
                        ]); ?>

                        <div class="row">

                            <div class="col-md-4">
                                <?= $form->field($model, 'firstname') ?>
                            </div>

                            <div class="col-md-4">
                                <?= $form->field($model, 'middlename') ?>
                            </div>

                            <div class="col-md-4">
                                <?= $form->field($model, 'lastname') ?>
                            </div>

                            <div class="col-md-6">
                                <?= $form->field($model, 'birthday')->input('date') ?>
                            </div>

                            <div class="col-md-6">
                                <?= $form->field($model, 'contact') ?>
                            </div>

                            <div class="col-md-6">
                                <?= $form->field($model, 'gender')->dropDownList(
                                    Applicant::optsGender(),
                                    ['prompt' => '-- Select Sex --']
                                ) ?>
                            </div>

                            <div class="col-12 mt-3">

                                <?= Html::submitButton(
                                    'Submit Membership Application',
                                    [
                                        'class' => 'btn lp-btn-primary w-100 lp-btn-submit'
                                    ]
                                ) ?>

                                <p class="lp-form-note text-center mt-3">
                                    Your application will be reviewed before membership approval.
                                </p>

                            </div>

                        </div>

                        <?php ActiveForm::end(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>