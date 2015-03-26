<?php
$params = require(__DIR__ . '/params.php');
$config = [
    'id' => 'yetcms',
    'basePath' => APP_PATH,
    'vendorPath' => WEB_PATH . '/vendor',
    'bootstrap' => ['log'],
    'name' => 'YetCMS',
    'language'=>'zh-cn',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '123',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
       
        'assetManager' => [
        	'class' => 'yii\web\AssetManager',
        	'basePath' => '@webroot/static/assets',
        	'baseUrl'  => '@web/static/assets'
        ],
        'user' => [
        	'class' => 'app\modules\user\components\User',
            //'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
		       'enablePrettyUrl' => true,
		       'showScriptName' => false,
		       'enableStrictParsing' => false,
		       'rules'=>[
		           '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
		           'mplugin/local/<tab:\w+>' => 'mplugin/local',
		           'mplugin/ajax' => 'mplugin/ajax',
		       ],
		   ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
            'messageConfig' => [
                'from' => ['xiongchuan86@vip.qq.com' => 'Admin'], // this is needed for sending emails
                'charset' => 'UTF-8',
            ]
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
        'db' => require(__DIR__ . '/db.php'),
    ],
    'modules' => [
        'user' => [
	        'class' => 'app\modules\user\Module',
	        'loginRedirect' => '/dashboard/main',
	        'logoutRedirect'=>'/user/login'
	    ],
	    'plugin' => [
            'class' => 'app\modules\plugin\Module',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
