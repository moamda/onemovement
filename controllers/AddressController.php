<?php

namespace app\controllers;

use Yii;
use app\models\Refregion;
use app\models\Refbrgy;
use app\models\Refcitymun;
use app\models\Refprovince;
use yii\web\Controller;

class AddressController extends Controller
{
    private const DEP_DROP_CACHE_TTL = 86400;

    private function depDropResponse(array $output = []): array
    {
        return [
            'output' => $output,
            'selected' => '',
        ];
    }

    private function getDepDropParent(): ?string
    {
        $parents = Yii::$app->request->post('depdrop_parents', []);

        if (!is_array($parents) || empty($parents[0])) {
            return null;
        }

        return (string)$parents[0];
    }

    private function rememberDepDrop(array $key, callable $callback): array
    {
        if (!Yii::$app->has('cache')) {
            return $callback();
        }

        return Yii::$app->cache->getOrSet($key, $callback, self::DEP_DROP_CACHE_TTL);
    }

    public function actionProvinceList()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $regionPsgc = $this->getDepDropParent();

        if ($regionPsgc === null) {
            return $this->depDropResponse();
        }

        $out = $this->rememberDepDrop(['depdrop-province-list', $regionPsgc], function () use ($regionPsgc) {
            $regionCode = Refregion::find()
                ->select('regCode')
                ->where(['psgcCode' => $regionPsgc])
                ->scalar();

            if (empty($regionCode)) {
                return [];
            }

            return Refprovince::find()
                ->select([
                    'id' => 'psgcCode',
                    'name' => 'provDesc',
                ])
                ->where(['regCode' => $regionCode])
                ->orderBy(['provDesc' => SORT_ASC])
                ->asArray()
                ->all();
        });

        return $this->depDropResponse($out);
    }

    public function actionCityList()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $provincePsgc = $this->getDepDropParent();

        if ($provincePsgc === null) {
            return $this->depDropResponse();
        }

        $out = $this->rememberDepDrop(['depdrop-city-list', $provincePsgc], function () use ($provincePsgc) {
            $provinceCode = Refprovince::find()
                ->select('provCode')
                ->where(['psgcCode' => $provincePsgc])
                ->scalar();

            if (empty($provinceCode)) {
                return [];
            }

            return Refcitymun::find()
                ->select([
                    'id' => 'psgcCode',
                    'name' => 'citymunDesc',
                ])
                ->where(['provCode' => $provinceCode])
                ->orderBy(['citymunDesc' => SORT_ASC])
                ->asArray()
                ->all();
        });

        return $this->depDropResponse($out);
    }

    public function actionBarangayList()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $cityPsgc = $this->getDepDropParent();

        if ($cityPsgc === null) {
            return $this->depDropResponse();
        }

        $out = $this->rememberDepDrop(['depdrop-barangay-list', $cityPsgc], function () use ($cityPsgc) {
            $cityCode = Refcitymun::find()
                ->select('citymunCode')
                ->where(['psgcCode' => $cityPsgc])
                ->scalar();

            if (empty($cityCode)) {
                return [];
            }

            return Refbrgy::find()
                ->select([
                    'id' => 'brgyCode',
                    'name' => 'brgyDesc',
                ])
                ->where(['citymunCode' => $cityCode])
                ->orderBy(['brgyDesc' => SORT_ASC])
                ->asArray()
                ->all();
        });

        return $this->depDropResponse($out);
    }
}
