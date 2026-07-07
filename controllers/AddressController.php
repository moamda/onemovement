<?php

namespace app\controllers;

use Yii;
use app\models\Applicant;
use app\models\ApplicantSearch;
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
                $regCode = $parents[0];
                $items = Refprovince::find()->where(['regCode' => $regCode])->orderBy('provDesc')->all();

                foreach ($items as $item) {
                    $out[] = [
                        'id' => $item->provCode,
                        'name' => $item->provDesc,
                    ];
                }

                return [
                    'output' => $out,
                    'selected' => ''
                ];
            }
        }

        return [
            'output' => '',
            'selected' => ''
        ];
    }

    public function actionCityList()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = [];

        if (isset($_POST['depdrop_parents'])) {

            $parents = $_POST['depdrop_parents'];

            if (!empty($parents)) {

                $provCode = $parents[0];

                $items = Refcitymun::find()
                    ->where(['provCode' => $provCode])
                    ->orderBy('citymunDesc')
                    ->all();

                foreach ($items as $item) {
                    $out[] = [
                        'id' => $item->citymunCode,
                        'name' => $item->citymunDesc,
                    ];
                }

                return [
                    'output' => $out,
                    'selected' => ''
                ];
            }
        }

        return [
            'output' => [],
            'selected' => ''
        ];
    }

    public function actionBarangayList()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = [];

        if (isset($_POST['depdrop_parents'])) {

            $parents = $_POST['depdrop_parents'];

            if (!empty($parents)) {

                $citymunCode = $parents[0];

                $items = Refbrgy::find()
                    ->where(['citymunCode' => $citymunCode])
                    ->orderBy('brgyDesc')
                    ->all();

                foreach ($items as $item) {
                    $out[] = [
                        'id' => $item->brgyCode,
                        'name' => $item->brgyDesc,
                    ];
                }

                return [
                    'output' => $out,
                    'selected' => ''
                ];
            }
        }

        return [
            'output' => [],
            'selected' => ''
        ];
    }
}
