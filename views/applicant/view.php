<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\Applicant $model */

$this->title = 'Applicant Information';
$this->params['breadcrumbs'][] = ['label' => 'Applicants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$status = strtolower($model->status);

switch ($status) {
    case 'approved':
        $badge = 'success';
        break;

    case 'pending':
        $badge = 'warning';
        break;

    case 'rejected':
        $badge = 'danger';
        break;

    default:
        $badge = 'secondary';
        break;
}
?>

<div class="applicant-view">

    <div class="row">

        <!-- LEFT PANEL -->
        <div class="col-md-4">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        Applicant Status
                    </h3>
                </div>

                <div class="card-body text-center">

                    <span class="badge bg-<?= $badge ?>" style="font-size:16px;padding:10px 20px;">
                        <?= strtoupper($status) ?>
                    </span>

                    <hr>

                    <h5>Government ID</h5>

                    <?= Html::img(
                        Url::to([
                            'view-government-id',
                            'id' => $model->id,
                        ]),
                        [
                            'class' => 'img-fluid img-thumbnail mb-3',
                            'style' => 'max-height:250px'
                        ]
                    ) ?>

                    <hr>

                    <h5>Signature</h5>

                    <?= Html::img(
                        Url::to([
                            'view-signature',
                            'id' => $model->id,
                        ]),
                        [
                            'class' => 'img-fluid img-thumbnail',
                            'style' => 'max-height:180px'
                        ]
                    ) ?>

                </div>

            </div>

        </div>

        <!-- RIGHT PANEL -->
        <div class="col-md-8">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user mr-2"></i>
                        Personal Information
                    </h3>
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <strong>First Name</strong>
                            <p><?= Html::encode($model->personal_information_firstname) ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Last Name</strong>
                            <p><?= Html::encode($model->personal_information_lastname) ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Middle Name</strong>
                            <p><?= Html::encode($model->personal_information_middlename) ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Extension Name</strong>
                            <p><?= Html::encode($model->personal_information_extension_name) ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Gender</strong>
                            <p><?= Html::encode($model->personal_information_gender) ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Contact Number</strong>
                            <p><?= Html::encode($model->personal_information_contact) ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Birthday</strong>
                            <p>
                                <?= Yii::$app->formatter->asDate(
                                    $model->personal_information_birthday,
                                    'MMMM d, yyyy'
                                ) ?>
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Age</strong>
                            <p><?= Html::encode($model->personal_information_age) ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Civil Status</strong>
                            <p><?= Html::encode($model->personal_information_civil_status) ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Email</strong>
                            <p><?= Html::encode($model->personal_information_email) ?></p>
                        </div>

                    </div>

                </div>



            </div>



        </div>

    </div>

    <div class="row">

        <div class="col-md-12">
            <!-- Address Information -->
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        Address Information
                    </h3>
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <strong>Region</strong>
                            <p><?= $model->region->regDesc ?? '-' ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Province</strong>
                            <p><?= $model->province->provDesc ?? '-' ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Municipality / City</strong>
                            <p><?= $model->municipality->citymunDesc ?? '-' ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Barangay</strong>
                            <p><?= $model->barangay->brgyDesc ?? '-' ?></p>
                        </div>

                        <div class="col-md-12">
                            <strong>Street / District</strong>
                            <p><?= $model->address_details_district_street ?: '-' ?></p>
                        </div>

                    </div>

                </div>

            </div>

            <!-- Employment Information -->
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-briefcase mr-2"></i>
                        Employment Information
                    </h3>
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4">
                            <strong>Occupation</strong>
                            <p><?= $model->employment_information_occupation ?: '-' ?></p>
                        </div>

                        <div class="col-md-4">
                            <strong>Sector</strong>
                            <p><?= $model->employment_information_sector_of_employment ?: '-' ?></p>
                        </div>

                        <div class="col-md-4">
                            <strong>Salary</strong>
                            <p><?= $model->employment_information_salary ?: '-' ?></p>
                        </div>

                    </div>

                </div>

            </div>

            <!-- Emergency Contact -->
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-phone mr-2"></i>
                        Emergency Contact
                    </h3>
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4">
                            <strong>Full Name</strong>
                            <p><?= $model->emergency_contact_fullname ?: '-' ?></p>
                        </div>

                        <div class="col-md-4">
                            <strong>Contact Number</strong>
                            <p><?= $model->emergency_contact_number ?: '-' ?></p>
                        </div>

                        <div class="col-md-4">
                            <strong>Address</strong>
                            <p><?= $model->emergency_contact_address ?: '-' ?></p>
                        </div>

                    </div>

                </div>

            </div>

            <!-- Volunteer Information -->
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-hands-helping mr-2"></i>
                        Volunteer Information
                    </h3>
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <strong>Registration Type</strong>
                            <p>
                                <?= $model::optsVolunteerDetailsRegistrationType()[$model->volunteer_details_registration_type] ?? '-' ?>
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Alliance Name</strong>
                            <p><?= $model->alliance->organization ?? '-' ?></p>
                        </div>

                    </div>

                </div>

            </div>

            <!-- System Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-clock mr-2"></i>
                        System Information
                    </h3>
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6">
                            <strong>APPLICATION DATE</strong>

                            <p>
                                <?= Yii::$app->formatter->asDatetime(
                                    $model->created_at,
                                    'MMMM d, yyyy h:mm:ss a'
                                ) ?>
                            </p>
                        </div>

                    </div>

                </div>

            </div>
        </div>



    </div>

</div>

<style>
    .applicant-view strong {
        display: block;
        color: #6c757d;
        font-size: 13px;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .applicant-view p {
        font-size: 15px;
        color: #212529;
        margin-bottom: 18px;
    }

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