<?php
$params = require(__DIR__ . '/params.php');
$config = [
    'id' => 'openadm',
    'basePath' => APP_PATH,
    'vendorPath' => WEB_PATH . '/../vendor',
    'runtimePath' => '@app/../runtime',
    'bootstrap' => ['log'],
    'name' => 'OpenAdm',
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
		        '*' => [
		            'class' => 'yii\i18n\PhpMessageSource',
		        ],
		    ],
		],
        'assetManager' => [
        	'class' => 'yii\web\AssetManager',
        	'basePath' => '@webroot/static/assets',
        	'baseUrl'  => '@web/static/assets'
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
		       'enablePrettyUrl' => true,
		       'showScriptName' => false,
		       'enableStrictParsing' => false,
		       'rules'=>[
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
            'ruleTable' => '{{%auth_rule}}', // Optional
            'itemTable' => '{{%auth_item}}',  // Optional
            'itemChildTable' => '{{%auth_item_child}}',  // Optional
            'assignmentTable' => '{{%auth_assignment}}',  // Optional
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
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/adminlte2/views',
                    '@vendor/yii2mod/yii2-rbac/views' => '@app/themes/adminlte2/modules/rbac/views',
                    '@vendor/amnah/yii2-user/views' => '@app/themes/adminlte2/modules/user/views',
                ],
            ],
        ],
        'user' => [
            'class' => 'amnah\yii2\user\components\User',
        ],

    ],
    //globally whole applications
    'as access' => [
        'class' => yii2mod\rbac\filters\AccessControl::class,
        'allowActions' => [
            //'site/*',
            //'admin/*',
            'user/*'
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],
    'modules' => [
        'noty' => [
            'class' => 'lo\modules\noty\Module',
        ],
        'user' => [
            'class' => 'amnah\yii2\user\Module',
	        'loginRedirect' => '/dashboard/main',
	        'logoutRedirect'=>'/user/login',
            'controllerMap' => [
                'admin' => [
                    'class' => 'app\modules\user\controllers\AdminController',
                ]
            ],
	    ],
	    'plugin' => [
            'class' => 'app\modules\plugin\Module',
        ],
        'rbac' => [
            'class' => 'yii2mod\rbac\Module',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'yii2mod\rbac\controllers\AssignmentController',
                ],
                'role' => [
                    'class' => 'app\modules\rbac\controllers\RoleController',
                ]
            ],
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
