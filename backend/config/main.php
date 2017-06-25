<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'defaultRoute'=>'user/index',
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],

        'user' => [
            'identityClass' => 'backend\models\UserBackend',
            'loginUrl'=>['user/login'],
            'enableAutoLogin' => true,
            'authTimeout'=>3600,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'Qiniu'=>[
            'class'=>\backend\component\Qiniu::className(),
            'up_host' => 'http://up-z2.qiniu.com',
            'accessKey'=>'KZ96ez0ladEdYzJm88E9ny3aQkbZBWi5vXy1eP1Z',
            'secretKey'=>'oYh4ySoX2pZZh0mKw1LTKhiHIuRaLd6GnSS9gAGl',
            'bucket'=>'shj1995',
            'domain'=>'http://or9qpxgdy.bkt.clouddn.com/',
        ],


    ],
    'params' => $params,
];
