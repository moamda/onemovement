<?php

use app\models\Applicant;
use app\models\Member;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\Member $model */

$this->title = 'Member Information';
$this->params['breadcrumbs'][] = ['label' => 'Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$status = strtolower($model->status);

switch ($status) {
    case 'active':
        $badge = 'success';
        break;

    case 'inactive':
        $badge = 'danger';
        break;

    default:
        $badge = 'secondary';
        break;
}
?>

<div class="member-view">

    <div class="row">

        <!-- LEFT PANEL -->
        <div class="col-md-4">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        Member Status
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
                            'applicant/view-government-id',
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
                            'applicant/view-signature',
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
                            <p><?= Html::encode($model->applicant->personal_information_firstname) ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Last Name</strong>
                            <p><?= Html::encode($model->applicant->personal_information_lastname) ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Middle Name</strong>
                            <p><?= Html::encode($model->applicant->personal_information_middlename) ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Extension Name</strong>
                            <p><?= Html::encode($model->applicant->personal_information_extension_name) ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Gender</strong>
                            <p><?= Html::encode($model->applicant->personal_information_gender) ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Contact Number</strong>
                            <p><?= Html::encode($model->applicant->personal_information_contact) ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Birthday</strong>
                            <p>
                                <?= Yii::$app->formatter->asDate(
                                    $model->applicant->personal_information_birthday,
                                    'MMMM d, yyyy'
                                ) ?>
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Age</strong>
                            <p><?= Html::encode($model->applicant->personal_information_age) ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Civil Status</strong>
                            <p><?= Html::encode($model->applicant->personal_information_civil_status) ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Email</strong>
                            <p><?= Html::encode($model->applicant->personal_information_email) ?></p>
                        </div>

                    </div>

                </div>



            </div>
        </div>

    </div>

    <div class="row">

        <!-- RIGHT PANEL -->
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
                            <p><?= $model->applicant->region->regDesc ?? '-' ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Province</strong>
                            <p><?= $model->applicant->province->provDesc ?? '-' ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Municipality / City</strong>
                            <p><?= $model->applicant->municipality->citymunDesc ?? '-' ?></p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Barangay</strong>
                            <p><?= $model->applicant->barangay->brgyDesc ?? '-' ?></p>
                        </div>

                        <div class="col-md-12">
                            <strong>Street / District</strong>
                            <p><?= $model->applicant->address_details_district_street ?: '-' ?></p>
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
                            <p><?= $model->applicant->employment_information_occupation ?: '-' ?></p>
                        </div>

                        <div class="col-md-4">
                            <strong>Sector</strong>
                            <p><?= $model->applicant->employment_information_sector_of_employment ?: '-' ?></p>
                        </div>

                        <div class="col-md-4">
                            <strong>Salary</strong>
                            <p><?= $model->applicant->employment_information_salary ?: '-' ?></p>
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
                            <p><?= $model->applicant->emergency_contact_fullname ?: '-' ?></p>
                        </div>

                        <div class="col-md-4">
                            <strong>Contact Number</strong>
                            <p><?= $model->applicant->emergency_contact_number ?: '-' ?></p>
                        </div>

                        <div class="col-md-4">
                            <strong>Address</strong>
                            <p><?= $model->applicant->emergency_contact_address ?: '-' ?></p>
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
                                <?= Applicant::optsVolunteerDetailsRegistrationType()[$model->applicant->volunteer_details_registration_type] ?? '-' ?>
                            </p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Alliance Name</strong>
                            <p><?= $model->applicant->alliance->organization ?? '-' ?></p>
                        </div>

                    </div>

                </div>

            </div>

            <!-- System Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-check"></i>
                        Member Activities
                    </h3>
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6">
                            <?php if (!empty($model->memberActivities)) : ?>

                                <table class="table table-bordered table-hover">

                                    <thead>
                                        <tr>
                                            <th width="50">#</th>
                                            <th>Activity</th>
                                            <!-- <th>Date Joined</th> -->
                                        </tr>
                                    </thead>


                                    <tbody>

                                        <?php foreach ($model->memberActivities as $i => $memberActivity): ?>

                                            <tr>

                                                <td>
                                                    <?= $i + 1 ?>
                                                </td>


                                                <td>
                                                    <?= $memberActivity->activity->activity_name ?? '-' ?>
                                                </td>


                                                <!-- <td>
                                    <= $memberActivity->created_at
                                        ? Yii::$app->formatter->asDate($memberActivity->created_at)
                                        : '-' ?>
                                </td> -->

                                            </tr>

                                        <?php endforeach; ?>

                                    </tbody>

                                </table>

                            <?php else: ?>

                                <div class="alert alert-secondary mb-0">
                                    No activities assigned to this member.
                                </div>

                            <?php endif; ?>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<style>
    .member-view strong {
        display: block;
        color: #6c757d;
        font-size: 13px;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .member-view p {
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