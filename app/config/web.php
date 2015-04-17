<?php
$params = require(__DIR__ . '/params.php');
$config = [
    'id' => 'yetcms',
    'basePath' => APP_PATH,
    'vendorPath' => WEB_PATH . '/vendor',
    'bootstrap' => ['log'],
    'name' => 'YetCMS',
    'language'=>'zh-CN',
    'on beforeRequest' =>['app\common\SystemEvent','beforeRequest'],
    'on beforeAction' => ['app\common\SystemEvent','beforeAction'],
    
    'components' => [
    	
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '123',
            'enableCsrfValidation' => false,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
		    'translations' => [
		        'user*' => [
		            'class' => 'yii\i18n\PhpMessageSource',
		        ],
		    ],
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
		           //'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
		           'mplugin/local/<tab:\w+>' => 'mplugin/local',
		       ],
		   ],
		
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
            	'from'  => '41404756@qq.com',
            ],
	        'transport' => [
	              'class' => 'Swift_SmtpTransport',
	              'host' => 'smtp.qq.com',
	              'username' => '',
	              'password' => '',
	              //'port' => '465',
	              //'encryption' => 'tls',
	        ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest', 'user'],
            'cache' => 'yii\caching\FileCache',
            'ruleTable' => '{{%AuthRule}}', // Optional
            'itemTable' => '{{%AuthItem}}',  // Optional
            'itemChildTable' => '{{%AuthItemChild}}',  // Optional
            'assignmentTable' => '{{%AuthAssignment}}',  // Optional
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
        'rbac' => [
            'class' => 'app\modules\rbac\Module',
            //Some controller property maybe need to change. 
            'controllerMap' => [
                'assignment' => [
                    'class' => 'app\modules\rbac\controllers\AssignmentController',
                    'userClassName' => 'app\modules\user\models\User',
                ]
            ]
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
