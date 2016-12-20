<?php
$params = array_merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
$config = [
    'id' => 'openadm',
    'basePath' => '@app',
    'vendorPath' => '@vendor',
    'runtimePath' => '@runtime',
    'bootstrap' => ['log'],
    'name' => 'OpenAdm',
    'language'=>'zh-CN',
    'sourceLanguage' => 'en-US',
    'on beforeRequest' =>['app\common\SystemEvent','beforeRequest'],
    'on beforeAction' => ['app\common\SystemEvent','beforeAction'],
    
    'components' => [

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
		    'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@app/messages',
                ],
		        'user' => [
		            'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@app/messages',
		        ],
                'noty' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@app/messages',
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
            'user/default/login',
            'user/default/register',
            'user/default/index',
            'user/default/resend',
            'user/default/forgot',
            'user/default/reset',
            'user/default/confirm',
            'user/auth/login',
            'user/auth/connect',
            'user/default/login-callback',
            'site/*',
            'debug/*',
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
            'requireEmail' => false,
            'requireUsername' => true,
            'controllerMap' => [
                'admin' => [
                    'class' => 'app\modules\user\controllers\AdminController',
                    'protected_uids' => [1],
                    'superadmin_uid' => 1,//超级管理员
                ],
                'default' => [
                    'class' => 'app\modules\user\controllers\DefaultController',
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

return $config;
