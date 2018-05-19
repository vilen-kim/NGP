<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$url = require __DIR__ . '/url.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'language' => 'ru-RU',
    'components' => [
        'request' => [
            'cookieValidationKey' => 'BcTcGa8D7GXFw119IC42bFNTURoUsOY-',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Auth',
            'enableAutoLogin' => true,
            'loginUrl' => ['auth/login'],
            'on afterLogin' => function($event) {
                Yii::$app->user->identity->updateAttributes(['login_at' => time()]);
            },
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => yii\swiftmailer\Mailer::class,
            'transport' => [
                'class' => Swift_SmtpTransport::class,
                'host' => 'cpanel17.d.fozzy.com',
                'username' => 'noreply@aus86.ru',
                'password' => "U'csng7QK;R5p{ke",
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => '6LdBzTkUAAAAAMUncb8Hf9kT-0XFK_NSTaBs-K5f',
            'secret' => '6LdBzTkUAAAAAOgWZ4eLzEbwhGa7xO6cAmEgS_AM',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'maxLogFiles' => 10
                ],
            ],
        ],
        'db' => $db,
        'baseUrl' => '',
        'urlManager' => $url,
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = [
//        'class' => 'yii\debug\Module',
//        'allowedIPs' => ['127.0.0.1', '::1'],
//    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
