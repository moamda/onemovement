<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use onmotion\apexcharts\ApexchartsWidget;

$this->title = 'Dashboard Applicants Reports';

$this->registerJsFile('@web/plugins/jspdf/jspdf.umd.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerJsFile('@web/js/dashboard-report.js', ['depends' => [\yii\web\JqueryAsset::class]]);

?>

<div class="mb-3 text-right">
  <button id="downloadDashboardPdf" class="btn btn-danger">
    <i class="fas fa-file-pdf"></i>
    Download PDF
  </button>
</div>

<section class="content">

  <div class="container-fluid">

    <!-- ====================================================== -->
    <!-- DASHBOARD FILTERS -->
    <!-- ====================================================== -->

    <div class="card card-outline card-primary">

      <div class="card-header">

        <h3 class="card-title">
          <i class="fas fa-filter mr-2"></i>
          Dashboard Filters
        </h3>

      </div>

      <div class="card-body">

        <?php $form = ActiveForm::begin([
          'method' => 'get',
        ]); ?>

        <div class="row">

          <!-- YEAR -->
          <div class="col-md-2">

            <?= Select2::widget([
              'name' => 'year',
              'value' => Yii::$app->request->get('year'),
              'data' => array_combine(
                range(date('Y'), date('Y') - 10),
                range(date('Y'), date('Y') - 10)
              ),
              'options' => [
                'placeholder' => 'Year',
              ],
              'pluginOptions' => [
                'allowClear' => true,
              ],
            ]) ?>

          </div>

          <!-- STATUS -->
          <div class="col-md-2">

            <?= Select2::widget([
              'name' => 'status',
              'value' => Yii::$app->request->get('status'),
              'data' => \app\models\Applicant::optsStatus(),
              'options' => [
                'placeholder' => 'Status',
              ],
              'pluginOptions' => [
                'allowClear' => true,
              ],
            ]) ?>

          </div>

          <!-- REGISTRATION TYPE -->
          <div class="col-md-2">

            <?= Select2::widget([
              'name' => 'registration_type',
              'value' => Yii::$app->request->get('registration_type'),
              'data' => \app\models\Applicant::optsVolunteerDetailsRegistrationType(),
              'options' => [
                'placeholder' => 'Registration Type',
              ],
              'pluginOptions' => [
                'allowClear' => true,
              ],
            ]) ?>

          </div>

          <!-- REGION -->
          <div class="col-md-4">

            <?= Select2::widget([
              'name' => 'region',
              'value' => Yii::$app->request->get('region'),
              'data' => \yii\helpers\ArrayHelper::map(
                \app\models\Refregion::find()->orderBy('regDesc')->all(),
                'psgcCode',
                'regDesc'
              ),
              'options' => [
                'id' => 'dashboard-region',
                'placeholder' => 'Region',
              ],
              'pluginOptions' => [
                'allowClear' => true,
              ],
            ]) ?>

          </div>

          <!-- PROVINCE -->
          <div class="col-md-2">

            <?= \kartik\depdrop\DepDrop::widget([
              'name' => 'province',
              'value' => Yii::$app->request->get('province'),

              'options' => [
                'id' => 'dashboard-province',
              ],

              'pluginOptions' => [
                'depends' => ['dashboard-region'],
                'placeholder' => 'Province',

                // PALITAN NATIN ITO MAMAYA
                'url' => \yii\helpers\Url::to(['/address/province-list']),
              ],
            ]) ?>

          </div>

        </div>

        <hr>

        <div class="text-right">

          <?= Html::submitButton(
            '<i class="fas fa-search"></i> Apply Filters',
            [
              'class' => 'btn btn-primary',
            ]
          ) ?>

          <?= Html::a(
            '<i class="fas fa-sync"></i> Reset',
            ['v1'],
            [
              'class' => 'btn btn-default',
            ]
          ) ?>

        </div>

        <?php ActiveForm::end(); ?>

      </div>

    </div>

    <!-- ====================================================== -->
    <!-- SUMMARY CARDS -->
    <!-- ====================================================== -->

    <div class="row">

      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?= number_format($totalApplicants) ?></h3>
            <p>Total Applicants</p>
          </div>

          <div class="icon">
            <i class="fas fa-users"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?= number_format($approved) ?></h3>
            <p>Approved</p>
          </div>

          <div class="icon">
            <i class="fas fa-user-check"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3><?= number_format($pending) ?></h3>
            <p>Pending</p>
          </div>

          <div class="icon">
            <i class="fas fa-user-clock"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3><?= number_format($rejected) ?></h3>
            <p>Rejected</p>
          </div>

          <div class="icon">
            <i class="fas fa-user-times"></i>
          </div>
        </div>
      </div>

    </div>

    <!-- ====================================================== -->
    <!-- REGISTRATION TREND -->
    <!-- ====================================================== -->

    <div class="row">

      <div class="col-md-8">

        <div class="card card-outline card-primary">

          <div class="card-header">
            <h3 class="card-title">
              Registration Trend (Last 12 Months)
            </h3>
          </div>

          <div class="card-body">

            <?= ApexchartsWidget::widget([
              'type' => 'line',
              'height' => 350,

              'series' => [
                [
                  'name' => 'Applicants',
                  'data' => $totals,
                ]
              ],

              'chartOptions' => [

                'chart' => [
                  'id' => 'registrationTrendChart',
                  'toolbar' => [
                    'show' => false,
                  ],
                  'zoom' => [
                    'enabled' => false,
                  ],
                ],

                'stroke' => [
                  'curve' => 'smooth',
                  'width' => 3,
                ],

                'markers' => [
                  'size' => 5,
                ],

                'dataLabels' => [
                  'enabled' => false,
                ],

                'colors' => [
                  '#007bff',
                ],

                'grid' => [
                  'borderColor' => '#f4f4f4',
                ],

                'xaxis' => [
                  'categories' => $labels,
                ],

                'yaxis' => [
                  'min' => 0,
                ],

              ],
            ]); ?>

          </div>

        </div>

      </div>

      <!-- Registration Type -->
      <div class="col-md-4">

        <div class="card card-outline card-danger">

          <div class="card-header">
            <h3 class="card-title">Registration Type</h3>
          </div>

          <div class="card-body">

            <?= ApexchartsWidget::widget([
              'type' => 'pie',
              'height' => 350,

              'series' => $registrationTotals,

              'chartOptions' => [
                'chart' => [
                  'id' => 'registrationTypeChart',
                  'toolbar' => [
                    'show' => false,
                  ],
                ],

                'labels' => $registrationLabels,

                'legend' => [
                  'position' => 'bottom',
                ],

              ],
            ]); ?>

          </div>

        </div>

      </div>

    </div>



    <!-- ====================================================== -->
    <!-- PROVINCE & GENDER -->
    <!-- ====================================================== -->

    <div class="row">

      <!-- Members per Region -->
      <div class="col-md-6">

        <div class="card card-outline card-success">

          <div class="card-header">
            <h3 class="card-title">Members per Region</h3>
          </div>

          <div class="card-body">

            <?= ApexchartsWidget::widget([
              'type' => 'bar',
              'height' => 350,

              'series' => [
                [
                  'name' => 'Members',
                  'data' => $regionTotals,
                ]
              ],

              'chartOptions' => [

                'chart' => [
                  'id' => 'membersPerRegionChart',
                  'toolbar' => [
                    'show' => false,
                  ],
                ],

                'plotOptions' => [
                  'bar' => [
                    'horizontal' => true,
                    'borderRadius' => 4,
                  ],
                ],

                'colors' => ['#28a745'],

                'dataLabels' => [
                  'enabled' => true,
                ],

                'xaxis' => [
                  'categories' => $regionLabels,
                ],

                'legend' => [
                  'show' => false,
                ],

              ],
            ]); ?>

          </div>

        </div>

      </div>
      <!-- Members per Alliance -->
      <div class="col-md-6">

        <div class="card card-outline card-primary">

          <div class="card-header">
            <h3 class="card-title">Members per Alliance</h3>
          </div>

          <div class="card-body">

            <?= ApexchartsWidget::widget([
              'type' => 'bar',
              'height' => 350,

              'series' => [
                [
                  'name' => 'Members',
                  'data' => $allianceTotals,
                ]
              ],

              'chartOptions' => [
                'chart' => [
                  'id' => 'membersPerAllianceChart',
                  'toolbar' => [
                    'show' => false,
                  ],
                ],

                'plotOptions' => [
                  'bar' => [
                    'horizontal' => true,
                    'borderRadius' => 4,
                  ]
                ],

                'colors' => ['#007bff'],

                'dataLabels' => [
                  'enabled' => true,
                ],

                'legend' => [
                  'show' => false,
                ],

                'xaxis' => [
                  'categories' => $allianceLabels,
                ],

              ],
            ]); ?>

          </div>

        </div>

      </div>


    </div>

    <div class="row">
      <!-- Civil Status -->
      <!-- <div class="col-md-4">

        <div class="card card-outline card-warning">

          <div class="card-header">
            <h3 class="card-title">Civil Status</h3>
          </div>

          <div class="card-body">

            <?= ApexchartsWidget::widget([
              'type' => 'pie',
              'height' => 330,

              'series' => $civilStatusTotals,

              'chartOptions' => [

                'chart' => [
                  'id' => 'civilStatusChart',
                  'toolbar' => [
                    'show' => false,
                  ],
                ],

                'labels' => $civilStatusLabels,

                'legend' => [
                  'position' => 'bottom',
                ],

              ],
            ]); ?>

          </div>

        </div>

      </div> -->

      <!-- Gender -->
      <!-- <div class="col-md-4">

        <div class="card card-outline card-info">

          <div class="card-header">
            <h3 class="card-title">Gender Distribution</h3>
          </div>

          <div class="card-body">

            <?= ApexchartsWidget::widget([
              'type' => 'donut',
              'height' => 350,

              'series' => $genderTotals,

              'chartOptions' => [

                'chart' => [
                  'id' => 'genderDistributionChart',
                  'toolbar' => [
                    'show' => false,
                  ],
                ],

                'labels' => $genderLabels,

                'legend' => [
                  'position' => 'bottom',
                ],

                'dataLabels' => [
                  'enabled' => true,
                ],

              ],
            ]); ?>

          </div>

        </div>

      </div> -->

      <!-- Employment Sector -->
      <!-- <div class="col-md-4">

        <div class="card card-outline card-secondary">

          <div class="card-header">
            <h3 class="card-title">Employment Sector</h3>
          </div>

          <div class="card-body">

            <?= ApexchartsWidget::widget([
              'type' => 'donut',
              'height' => 330,

              'series' => $employmentTotals,

              'chartOptions' => [

                'chart' => [
                  'id' => 'employmentSectorChart',
                  'toolbar' => [
                    'show' => false,
                  ],
                ],

                'labels' => $employmentLabels,

                'legend' => [
                  'position' => 'bottom',
                ],

              ],
            ]); ?>

          </div>

        </div>

      </div> -->
    </div>

    
    <div class="row">
      <!-- Age Distribution -->
      <!-- <div class="col-md-12">

        <div class="card card-outline card-dark">

          <div class="card-header">
            <h3 class="card-title">Age Distribution</h3>
          </div>

          <div class="card-body">

            <?= ApexchartsWidget::widget([
              'type' => 'bar',
              'height' => 330,

              'series' => [
                [
                  'name' => 'Members',
                  'data' => $ageTotals,
                ]
              ],

              'chartOptions' => [
                'chart' => [
                  'id' => 'ageDistributionChart',
                  'toolbar' => [
                    'show' => false,
                  ],
                ],

                'colors' => ['#343a40'],

                'plotOptions' => [
                  'bar' => [
                    'borderRadius' => 4,
                  ]
                ],

                'dataLabels' => [
                  'enabled' => true,
                ],

                'xaxis' => [
                  'categories' => $ageLabels,
                ],

                'legend' => [
                  'show' => false,
                ],

              ],
            ]); ?>

          </div>

        </div>

      </div> -->

    </div>
  </div>

</section>