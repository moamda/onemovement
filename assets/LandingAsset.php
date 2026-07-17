<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Asset bundle for the 1Okay Services landing page.
 * Uses Bootstrap 5 (yii2-bootstrap5).
 */
class LandingAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';

    public $css = [
        'css/landing.css',
        'plugins/bs-stepper/bs-stepper.min.css',
    ];

    public $js = [
        'js/landing.js',
        'plugins/bs-stepper/bs-stepper.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\bootstrap5\BootstrapPluginAsset',
        'hail812\adminlte3\assets\FontAwesomeAsset',
    ];
}
