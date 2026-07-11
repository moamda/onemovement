<?php

namespace app\modules\admin\controllers;

use app\models\Applicant;
use Yii;
use yii\db\Expression;
use app\modules\admin\models\User;
use app\modules\admin\models\UserSearch;
use app\modules\admin\models\SignupForm;
use app\modules\admin\models\Profile;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class DashboardController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                        [
                            'allow' => false,
                        ],
                    ],
                ],
            ]
        );
    }

    public function actionV1()
    {
        // ======================================================
        // DASHBOARD FILTERS
        // ======================================================

        $year = Yii::$app->request->get('year');
        $status = Yii::$app->request->get('status');
        $registrationType = Yii::$app->request->get('registration_type');
        $region = Yii::$app->request->get('region');
        $province = Yii::$app->request->get('province');

        // ======================================================
        // BASE QUERY
        // ======================================================

        $query = Applicant::find()->alias('a');

        /**
         * Filter by Year
         */
        if (!empty($year)) {
            $query->andWhere(new Expression('YEAR(a.created_at) = :year', [
                ':year' => $year,
            ]));
        }

        /**
         * Filter by Status
         */
        if (!empty($status)) {
            $query->andWhere([
                'a.status' => $status,
            ]);
        }

        /**
         * Filter by Registration Type
         */
        if (!empty($registrationType)) {
            $query->andWhere([
                'a.volunteer_details_registration_type' => $registrationType,
            ]);
        }

        /**
         * Filter by Region
         */
        if (!empty($region)) {
            $query->andWhere([
                'a.address_details_region' => $region,
            ]);
        }

        /**
         * Filter by Province
         */
        if (!empty($province)) {
            $query->andWhere([
                'a.address_details_province' => $province,
            ]);
        }

        // ======================================================
        // SUMMARY CARDS
        // ======================================================

        $totalApplicants = (clone $query)->count();

        $approved = (clone $query)
            ->andWhere(['a.status' => 'APPROVED'])
            ->count();

        $pending = (clone $query)
            ->andWhere(['a.status' => 'PENDING'])
            ->count();

        $rejected = (clone $query)
            ->andWhere(['a.status' => 'REJECTED'])
            ->count();

        // ======================================================
        // CHART 1 : REGISTRATION TREND
        // ======================================================

        $registrationTrend = (clone $query)
            ->select([
                new Expression("DATE_FORMAT(created_at, '%b') AS month"),
                new Expression("COUNT(*) AS total"),
            ])
            ->andWhere(new Expression("created_at >= DATE_SUB(CURDATE(), INTERVAL 11 MONTH)"))
            ->groupBy(new Expression("YEAR(created_at), MONTH(created_at)"))
            ->orderBy("YEAR(created_at) ASC, MONTH(created_at) ASC")
            ->asArray()
            ->all();

        $labels = array_column($registrationTrend, 'month');
        $totals = array_map('intval', array_column($registrationTrend, 'total'));



        // ======================================================
        // CHART 2 : MEMBERS PER PROVINCE
        // ======================================================

        $provinceData = (clone $query)
            ->select([
                'p.provDesc AS province',
                new Expression('COUNT(*) AS total'),
            ])
            ->leftJoin('refprovince p', 'p.psgcCode = a.address_details_province')
            ->groupBy([
                'p.psgcCode',
                'p.provDesc',
            ])
            ->orderBy([
                'total' => SORT_DESC,
            ])
            ->limit(10)
            ->asArray()
            ->all();

        // echo '<pre>';
        // print_r($provinceData);
        // die();

        /**
         * Convert query result into arrays for ApexCharts
         */
        $provinceLabels = [];
        $provinceTotals = [];

        foreach ($provinceData as $row) {
            $provinceLabels[] = $row['province'];
            $provinceTotals[] = (int) $row['total'];
        }

        // ======================================================
        // CHART 3 : GENDER DISTRIBUTION
        // ======================================================

        $genderData = (clone $query)
            ->select([
                'personal_information_gender',
                new Expression('COUNT(*) AS total'),
            ])
            ->groupBy('personal_information_gender')
            ->asArray()
            ->all();

        $genderLabels = array_column($genderData, 'personal_information_gender');
        $genderTotals = array_map('intval', array_column($genderData, 'total'));

        // ======================================================
        // CHART 4 : CIVIL STATUS
        // ======================================================

        $civilStatusData = (clone $query)
            ->select([
                'personal_information_civil_status',
                new Expression('COUNT(*) AS total'),
            ])
            ->groupBy('personal_information_civil_status')
            ->asArray()
            ->all();

        $civilStatusLabels = array_column($civilStatusData, 'personal_information_civil_status');
        $civilStatusTotals = array_map('intval', array_column($civilStatusData, 'total'));

        // ======================================================
        // CHART 5 : REGISTRATION TYPE
        // ======================================================

        $registrationTypeData = (clone $query)
            ->select([
                'volunteer_details_registration_type',
                new Expression('COUNT(*) AS total'),
            ])
            ->groupBy('volunteer_details_registration_type')
            ->asArray()
            ->all();

        $registrationLabels = [];
        $registrationTotals = [];

        foreach ($registrationTypeData as $row) {
            $registrationLabels[] = Applicant::optsVolunteerDetailsRegistrationType()[$row['volunteer_details_registration_type']] ?? 'Unknown';
            $registrationTotals[] = (int)$row['total'];
        }

        // ======================================================
        // CHART 6 : EMPLOYMENT SECTOR
        // ======================================================

        $employmentData = (clone $query)
            ->select([
                'employment_information_sector_of_employment',
                new Expression('COUNT(*) AS total'),
            ])
            ->groupBy('employment_information_sector_of_employment')
            ->asArray()
            ->all();

        $employmentLabels = [];
        $employmentTotals = [];

        foreach ($employmentData as $row) {
            $employmentLabels[] = Applicant::optsEmploymentInformationSectorOfEmployment()[$row['employment_information_sector_of_employment']] ?? 'N/A';
            $employmentTotals[] = (int)$row['total'];
        }

        // ======================================================
        // CHART 7 : MEMBERS PER ALLIANCE
        // ======================================================

        $allianceData = (clone $query)
            ->alias('a')
            ->select([
                'al.organization',
                new Expression('COUNT(*) AS total'),
            ])
            ->leftJoin('alliance al', 'al.id = a.volunteer_details_group_name')
            ->groupBy([
                'al.id',
                'al.organization',
            ])
            ->orderBy([
                'total' => SORT_DESC,
            ])
            ->limit(10)
            ->asArray()
            ->all();

        // Convert query result into arrays for ApexCharts
        $allianceLabels = [];
        $allianceTotals = [];

        foreach ($allianceData as $row) {
            $allianceLabels[] = $row['organization'] ?: 'No Alliance';
            $allianceTotals[] = (int) $row['total'];
        }

        // ======================================================
        // CHART 8 : AGE DISTRIBUTION
        // ======================================================

        $ageGroups = [
            '18-24' => 0,
            '25-34' => 0,
            '35-44' => 0,
            '45-54' => 0,
            '55+'   => 0,
        ];

        $ages = (clone $query)
            ->select('personal_information_age')
            ->andWhere(['a.status' => 'APPROVED'])
            ->column();

        foreach ($ages as $age) {

            if ($age >= 18 && $age <= 24) {
                $ageGroups['18-24']++;
            } elseif ($age <= 34) {
                $ageGroups['25-34']++;
            } elseif ($age <= 44) {
                $ageGroups['35-44']++;
            } elseif ($age <= 54) {
                $ageGroups['45-54']++;
            } else {
                $ageGroups['55+']++;
            }
        }

        $ageLabels = array_keys($ageGroups);
        $ageTotals = array_values($ageGroups);

        return $this->render('v1', [
            'totalApplicants' => $totalApplicants,
            'approved' => $approved,
            'pending' => $pending,
            'rejected' => $rejected,

            'labels' => $labels,
            'totals' => $totals,

            'provinceLabels' => $provinceLabels,
            'provinceTotals' => $provinceTotals,

            'genderLabels' => $genderLabels,
            'genderTotals' => $genderTotals,

            'civilStatusLabels' => $civilStatusLabels,
            'civilStatusTotals' => $civilStatusTotals,

            'registrationLabels' => $registrationLabels,
            'registrationTotals' => $registrationTotals,

            'allianceLabels' => $allianceLabels,
            'allianceTotals' => $allianceTotals,

            'employmentLabels' => $employmentLabels,
            'employmentTotals' => $employmentTotals,

            'ageLabels' => $ageLabels,
            'ageTotals' => $ageTotals,
        ]);
    }
}
