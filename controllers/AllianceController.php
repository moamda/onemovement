<?php

namespace app\controllers;

use app\models\Alliance;
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


class AllianceController extends Controller
{
    public function actionAllianceList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $output = [];

        if (isset($_POST['depdrop_parents'])) {

            $registrationType = $_POST['depdrop_parents'][0];

            // Convert enum value to its label
            $registrationTypes = Applicant::optsVolunteerDetailsRegistrationType();
            $registrationLabel = $registrationTypes[$registrationType] ?? '';

            if ($registrationLabel === 'ALLIANCE') {

                $items = Alliance::find()
                    ->orderBy(['organization' => SORT_ASC])
                    ->all();

                foreach ($items as $item) {
                    $output[] = [
                        'id' => $item->id,
                        'name' => $item->organization,
                    ];
                }
            }

            return [
                'output' => $output,
                'selected' => '',
            ];
        }

        return [
            'output' => [],
            'selected' => '',
        ];
    }
}
