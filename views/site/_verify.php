<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\Member $member */
/** @var app\models\Applicant $model */

use app\models\Applicant;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->registerCssFile('@web/css/applicant-form.css');

?>


<div class="applicant-form-page">

    <div class="applicant-form-header">
        <h2>Membership Verification Portal</h2>
        <p>
            Enter the member's personal information to verify the membership
            record.
        </p>
    </div>

    <div class="applicant-form">

        <?php $form = ActiveForm::begin([
            'id' => 'verification-form',
        ]); ?>

        <div class="accordion application-accordion">

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button">
                        <span class="step-badge"><i class="fa fa-search"></i></span>
                        <span class="step-title">Personal Information</span>
                    </button>
                </h2>

                <div class="accordion-body">

                    <div class="row">

                        <div class="col-lg-4">
                            <?= $form->field($model, 'personal_information_firstname')
                                ->textInput([
                                    'maxlength' => true,
                                    'style' => 'text-transform:uppercase'
                                ])->label('First Name <span class="text-danger">*</span>', ['encode' => false]) ?>
                        </div>

                        <div class="col-lg-4">
                            <?= $form->field($model, 'personal_information_middlename')
                                ->textInput([
                                    'maxlength' => true,
                                    'style' => 'text-transform:uppercase'
                                ]) ?>
                        </div>

                        <div class="col-lg-4">
                            <?= $form->field($model, 'personal_information_lastname')
                                ->textInput([
                                    'maxlength' => true,
                                    'style' => 'text-transform:uppercase'
                                ])->label('Last Name <span class="text-danger">*</span>', ['encode' => false]) ?>
                        </div>

                        <div class="col-lg-4">
                            <?= $form->field($model, 'personal_information_extension_name')
                                ->dropDownList(
                                    Applicant::optsPersonalInformationExtensionName(),
                                    ['prompt' => '']
                                ) ?>
                        </div>

                        <div class="col-lg-4">
                            <?= $form->field($model, 'personal_information_birthday')
                                ->input('date')->label('Birthday <span class="text-danger">*</span>', ['encode' => false]) ?>
                        </div>

                        <div class="col-lg-4">
                            <?= $form->field($model, 'personal_information_contact')
                                ->textInput()->label('Contact <span class="text-danger">*</span>', ['encode' => false]) ?>
                        </div>

                        <div class="col-lg-6">

                            <?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::class, [
                                'captchaAction' => 'site/captcha',
                                'template' => '
                                <div class="row">
                                    <div class="col-md-5">{image}</div>
                                    <div class="col-md-7">{input}</div>
                                </div>',
                            ])->label('Captcha <span class="text-danger">*</span>', ['encode' => false]) ?>

                        </div>

                    </div>

                    <div class="step-actions step-actions-end">

                        <?= Html::submitButton(
                            'Submit',
                            [
                                'class' => 'btn btn-maroon'
                            ]
                        ) ?>

                    </div>

                </div>

            </div>

        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <?php if ($member): ?>

        <div class="card mt-4">

            <div class="card-header bg-success text-white">
                Membership Verified
            </div>

            <div class="card-body p-0">

                <table class="table table-bordered table-striped mb-0">
                    <tr>
                        <th>Name</th>
                        <td><?= $member->applicant->personal_information_firstname . ' ' . $member->applicant->personal_information_middlename . ' ' . $member->applicant->personal_information_lastname . ' ' . $member->applicant->personal_information_extension_name ?></td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td><?= $member->status ?></td>
                    </tr>

                    <tr>
                        <th>Registration Type</th>
                        <td><?= $member->applicant->volunteer_details_registration_type ?></td>
                    </tr>

                    <tr>
                        <th>Group</th>
                        <td>
                            <?= $member->alliance
                                ? $member->alliance->name
                                : 'NO ASSIGNED GROUP' ?>
                        </td>
                    </tr>

                    <tr>
                        <th>Date Registered</th>
                        <td><?= Yii::$app->formatter->asDate($member->created_at) ?></td>
                    </tr>

                    <tr>
                        <th>Date Verified</th>
                        <td>
                            <?= Yii::$app->formatter->asDatetime(time()) ?>
                        </td>
                    </tr>

                </table>

            </div>

        </div>

    <?php elseif (Yii::$app->request->isPost): ?>

        <div class="alert alert-danger mt-4">
            <i class="fa fa-times-circle"></i>
            No membership record was found.
        </div>

    <?php endif; ?>

</div>