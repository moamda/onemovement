<?php

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\VerificationSearch $searchModel */

use app\models\Member;
use app\models\VerificationSearch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\LinkPager;

$this->registerCssFile('@web/css/applicant-form.css');

$this->title = 'Member Verification Portal';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="applicant-form-page">

    <div class="applicant-form-header">
        <h2>Member Verification Portal</h2>
        <p>
            Only verified, active members are displayed.
        </p>
    </div>

    <!-- Search Section -->
    <div class="container mb-5">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <?php $form = ActiveForm::begin([
                            'method' => 'get',
                            'action' => Url::to(['site/verification']),
                            'id' => 'verification-search-form',
                            'options' => ['class' => 'verification-form'],
                        ]); ?>

                        <div class="mb-0">
                            <div class="row g-2 align-items-end">
                                <div class="col-12 col-md">
                                    <?= $form->field($searchModel, 'keyword', [
                                        'options' => ['class' => 'mb-0'],
                                        'template' => '{label}{input}{error}',
                                    ])
                                        ->textInput([
                                            'placeholder' => 'Type any part of the member\'s name to search...',
                                            'class' => 'form-control form-control-lg',
                                            'autocomplete' => 'off',
                                            'style' => 'text-transform: uppercase;',
                                        ])
                                        ->label('Search Member', ['class' => 'form-label fw-bold mb-3']) ?>
                                </div>
                                <div class="col-12 col-md-auto d-flex gap-2">
                                    <?= Html::submitButton(
                                        '<i class="fa fa-search"></i> Search',
                                        [
                                            'class' => 'btn btn-danger btn-lg flex-grow-1 flex-md-grow-0',
                                            'style' => 'font-weight: 600;',
                                        ]
                                    ) ?>

                                    <?php if (!empty($searchModel->keyword)): ?>
                                        <?= Html::a(
                                            '<i class="fa fa-times"></i> Clear',
                                            Url::to(['site/verification']),
                                            [
                                                'class' => 'btn btn-outline-secondary btn-lg',
                                                'style' => 'font-weight: 600;',
                                            ]
                                        ) ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Section -->
    <div class="container mb-5">
        <?php if ($dataProvider->getTotalCount() > 0): ?>

            <!-- Results Table -->
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-bold">ID No.</th>
                            <th class="fw-bold">Name</th>
                            <!-- <th class="fw-bold">Registration Type</th>
                            <th class="fw-bold">Group</th> -->
                            <th class="fw-bold">Member Since</th>
                            <th class="fw-bold text-center">Activities</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dataProvider->getModels() as $member): ?>
                            <tr>
                                <td>
                                    <span class="mb-0 fw-bold">
                                        <?= Html::encode($member->applicant->application_no ?? 'N/A') ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="badge bg-success-subtle text-success me-3 p-2">
                                            <i class="fa fa-check"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">
                                                <?= Html::encode(VerificationSearch::getFullName($member)) ?>
                                            </h6>
                                        </div>
                                    </div>
                                </td>
                                <!-- <td>
                                    <span class="badge bg-info text-dark">
                                        <= Html::encode($member->applicant->volunteer_details_registration_type ?? 'N/A') ?>
                                    </span>
                                </td>
                                <td>
                                    <php if ($member->alliance): ?>
                                        <span class="text-muted">
                                            <= Html::encode($member->alliance->organization ?? 'N/A') ?>
                                        </span>
                                    <php else: ?>
                                        <span class="badge bg-light text-muted">Unassigned</span>
                                    <php endif; ?>
                                </td> -->
                                <td>
                                    <small class="text-muted">
                                        <?= Yii::$app->formatter->asDate($member->created_at) ?>
                                    </small>
                                </td>
                                <td class="text-center">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-primary view-activities-btn"
                                        data-member-id="<?= $member->id ?>"
                                        data-member-name="<?= Html::encode(VerificationSearch::getFullName($member)) ?>"
                                        data-bs-toggle="modal"
                                        data-bs-target="#activitiesModal"
                                    >
                                        <i class="fa fa-calendar"></i> Activities
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($dataProvider->pagination->pageCount > 1): ?>
                <nav aria-label="Page navigation" class="d-flex justify-content-center mt-4">
                    <?= LinkPager::widget([
                        'pagination' => $dataProvider->pagination,
                        'options' => ['class' => 'pagination'],
                        'linkOptions' => ['class' => 'page-link'],
                        'activePageCssClass' => 'active',
                        'disabledPageCssClass' => 'disabled',
                        'prevPageLabel' => '<i class="fa fa-chevron-left"></i>',
                        'nextPageLabel' => '<i class="fa fa-chevron-right"></i>',
                        'firstPageLabel' => '<i class="fa fa-chevron-left"></i> <i class="fa fa-chevron-left"></i>',
                        'lastPageLabel' => '<i class="fa fa-chevron-right"></i> <i class="fa fa-chevron-right"></i>',
                    ]) ?>
                </nav>
            <?php endif; ?>

        <?php elseif (!empty($searchModel->keyword)): ?>

            <!-- No Results Found -->
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <div class="text-center py-4">
                    <i class="fa fa-search fa-2x text-warning mb-3 d-block"></i>
                    <h4>No Members Found</h4>
                    <p class="text-muted mb-0">
                        No verified members matched your search for "<strong><?= Html::encode($searchModel->keyword) ?></strong>".
                    </p>
                    <p class="text-muted mt-2 small">
                        Try searching with different keywords or
                        <?= Html::a('clear your search', ['site/verification']) ?>.
                    </p>
                </div>
            </div>

        <?php else: ?>

            <!-- Initial State (No Search Yet) -->
            <div class="text-center py-5">
                <i class="fa fa-info-circle fa-2x text-info mb-3 d-block"></i>
                <h4>Ready to Search</h4>
                <p class="text-muted mb-0">
                    Use the search box above to find verified members by their name.
                </p>
            </div>

        <?php endif; ?>

    </div>

</div>

<!-- Member Activities Modal -->
<div class="modal fade" id="activitiesModal" tabindex="-1" aria-labelledby="activitiesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="activitiesModalLabel">
                    <i class="fa fa-calendar text-primary me-2"></i>
                    <span id="activitiesModalMemberName">Member</span> — Activities
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="activitiesModalContent">
                    <!-- Populated via JS -->
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<?php
// Pre-render activity data per member for JS consumption (no AJAX needed)
$activitiesData = [];
foreach ($dataProvider->getModels() as $member) {
    $memberActivities = [];
    foreach ($member->memberActivities as $ma) {
        if ($ma->activity) {
            $memberActivities[] = Html::encode($ma->activity->activity_name);
        }
    }
    $activitiesData[$member->id] = $memberActivities;
}

$activitiesJson = json_encode($activitiesData, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT);

$js = <<<JS
(function () {
    var activities = $activitiesJson;

    document.querySelectorAll('.view-activities-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var memberId   = this.dataset.memberId;
            var memberName = this.dataset.memberName;
            var list       = activities[memberId] || [];

            document.getElementById('activitiesModalMemberName').textContent = memberName;

            var content = '';

            if (list.length > 0) {
                content += '<ul class="list-group list-group-flush">';
                list.forEach(function (name) {
                    content += '<li class="list-group-item">' +
                               '<i class="fa fa-check-circle text-success me-2"></i>' + name +
                               '</li>';
                });
                content += '</ul>';
            } else {
                content = '<div class="text-center py-4">' +
                          '<i class="fa fa-calendar-times fa-2x text-muted mb-3 d-block"></i>' +
                          '<p class="text-muted mb-0">No activities recorded for this member.</p>' +
                          '</div>';
            }

            document.getElementById('activitiesModalContent').innerHTML = content;
        });
    });
}());
JS;

$this->registerJs($js);
?>