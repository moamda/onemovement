<?php

$params = require __DIR__ . '/params.php';
$onemovement_db_user = require __DIR__ . '/db/onemovement_db_user.php';
$onemovement_db_auth = require __DIR__ . '/db/onemovement_db_auth.php';
$onemovement_db_system = require __DIR__ . '/db/onemovement_db_system.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'rbac',
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        // 'view' => [
        //     'theme' => [
        //         'pathMap' => [
        //             '@app/views' => '@vendor/hail812/yii2-adminlte3/src/views'
        //         ],
        //     ],
        // ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'db' => 'onemovement_db_auth',
        ],
        'request' => [
            'cookieValidationKey' => 'SQ4ktLsm5pLWGjPQZ2NdVm5YwAFIym3Z',
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class,
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'mdm\admin\models\User',
            'loginUrl' => ['site/login'],
            'enableAutoLogin' => true,
            // 'authTimeout' => 900,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'yii2-ajaxcrud' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2ajaxcrud/ajaxcrud/messages',
                    'sourceLanguage' => 'en',
                ],
            ]
        ],
        'db' => $onemovement_db_user,
        'onemovement_db_user' => $onemovement_db_user,
        'onemovement_db_auth' => $onemovement_db_auth,
        'onemovement_db_system' => $onemovement_db_system,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'dashboard' => 'admin/dashboard/v1',
            ],
        ],

    ],

    // 'on beforeRequest' => function () {
    //     \yii\base\Event::on(\yii\web\View::class, \yii\web\View::EVENT_END_BODY, function () {
    //         if (\Yii::$app->user->isGuest) {
    //             return;
    //         }
    //         $url   = \yii\helpers\Url::to(['/site/logout']);
    //         $param = \Yii::$app->request->csrfParam;
    //         $csrf  = \Yii::$app->request->csrfToken;
    //         \Yii::$app->view->registerJs(
    //             "(function(){var T=900000,t;" .
    //                 "function r(){clearTimeout(t);t=setTimeout(x,T)}" .
    //                 "function x(){" .
    //                 "var f=document.createElement('form');" .
    //                 "f.method='post';f.action=" . json_encode($url) . ";" .
    //                 "var i=document.createElement('input');" .
    //                 "i.type='hidden';i.name=" . json_encode($param) . ";" .
    //                 "i.value=" . json_encode($csrf) . ";" .
    //                 "f.appendChild(i);document.body.appendChild(f);f.submit()" .
    //                 "}" .
    //                 "['mousemove','keypress','click','scroll','touchstart']" .
    //                 ".forEach(function(e){document.addEventListener(e,r,true)});" .
    //                 "r()})();"
    //         );
    //     });
    // },

    'params' => $params,

    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ],
        'rbac' => [
            'class' => 'mdm\admin\Module',
            'layout' => '/adminlte',
            'as access' => [
                'class' => 'yii\filters\AccessControl',
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
        ],
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'layout' => '/adminlte',
        ],
        'gii' => [
            'class' => yii\gii\Module::class,
            'generators' => [
                'crud' => [
                    'class' => yii\gii\generators\crud\Generator::class,
                    'templates' => [
                        'yii2-adminlte3' => '@vendor/hail812/yii2-adminlte3/src/gii/generators/crud/default'
                    ]
                ]
            ],
            'as access' => [
                'class' => 'yii\filters\AccessControl',
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
            'allowedIPs' => explode(',', getenv('GII_ALLOWED_IPS') ?: '127.0.0.1,::1'),

            // OPTIONAL: only enable if API Gii Generator is really needed
            // 'as giiBehaviors' => [
            //     'class' => \rgl\gii\GiiBehaviors::class,
            // ],
        ],
        'debug' => [
            'class' => yii\debug\Module::class,
            'as access' => [
                'class' => 'yii\filters\AccessControl',
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
            'allowedIPs' => explode(',', getenv('GII_ALLOWED_IPS') ?: '127.0.0.1,::1'),
        ],


    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    'yii2-adminlte3' => '@vendor/hail812/yii2-adminlte3/src/gii/generators/crud/default'
                ]
            ]
        ]
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
