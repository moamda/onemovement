<?php

namespace app\controllers;

use Yii;
use app\models\Applicant;
use app\models\ApplicantSearch;
use app\models\Refregion;
use app\models\Refbrgy;
use app\models\Refcitymun;
use app\models\Refprovince;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;


class AddressController extends Controller
{
    public function actionProvinceList()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = [];

        if (isset($_POST['depdrop_parents'])) {

            $parents = $_POST['depdrop_parents'];

            if (!empty($parents)) {

                // Selected Region PSGC Code
                $regionPsgc = $parents[0];

                // Get Region using PSGC Code
                $region = Refregion::findOne([
                    'psgcCode' => $regionPsgc,
                ]);

                if ($region) {

                    // Load provinces using Region Code
                    $items = Refprovince::find()
                        ->where([
                            'regCode' => $region->regCode,
                        ])
                        ->orderBy('provDesc')
                        ->all();

                    foreach ($items as $item) {
                        $out[] = [
                            'id' => $item->psgcCode,
                            'name' => $item->provDesc,
                        ];
                    }
                }

                return [
                    'output' => $out,
                    'selected' => '',
                ];
            }
        }

        return [
            'output' => [],
            'selected' => '',
        ];
    }

    public function actionCityList()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = [];

        if (isset($_POST['depdrop_parents'])) {

            $parents = $_POST['depdrop_parents'];

            if (!empty($parents)) {

                // Selected Province PSGC Code
                $provincePsgc = $parents[0];

                // Get Province using PSGC Code
                $province = Refprovince::findOne([
                    'psgcCode' => $provincePsgc,
                ]);

                if ($province) {

                    // Load Cities/Municipalities using Province Code
                    $items = Refcitymun::find()
                        ->where([
                            'provCode' => $province->provCode,
                        ])
                        ->orderBy('citymunDesc')
                        ->all();

                    foreach ($items as $item) {
                        $out[] = [
                            'id' => $item->psgcCode,
                            'name' => $item->citymunDesc,
                        ];
                    }
                }

                return [
                    'output' => $out,
                    'selected' => '',
                ];
            }
        }

        return [
            'output' => [],
            'selected' => '',
        ];
    }

    public function actionBarangayList()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = [];

        if (isset($_POST['depdrop_parents'])) {

            $parents = $_POST['depdrop_parents'];

            if (!empty($parents)) {

                // Selected City PSGC Code
                $cityPsgc = $parents[0];

                // Get City using PSGC Code
                $city = Refcitymun::findOne([
                    'psgcCode' => $cityPsgc,
                ]);

                if ($city) {

                    // Load Barangays using City/Municipality Code
                    $items = Refbrgy::find()
                        ->where([
                            'citymunCode' => $city->citymunCode,
                        ])
                        ->orderBy('brgyDesc')
                        ->all();

                    foreach ($items as $item) {
                        $out[] = [
                            // Barangay table has no psgcCode, so use brgyCode
                            'id' => $item->brgyCode,
                            'name' => $item->brgyDesc,
                        ];
                    }
                }

                return [
                    'output' => $out,
                    'selected' => '',
                ];
            }
        }

        return [
            'output' => [],
            'selected' => '',
        ];
    }
}
