<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
   
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/adminlte2/views',
                    '@vendor/yii2mod/yii2-rbac/views' => '@app/themes/adminlte2/modules/rbac/views',
                    '@vendor/amnah/yii2-user/views' => '@app/themes/adminlte2/modules/user/views',
                ],
            ],
        ],
    ],
    'modules' => [
//	    'user' => [
//	        'class' => 'app\modules\user\Module',
//	    ],
	    'gii' => 'yii\gii\Module',
        'rbac' => [
            'class' => 'yii2mod\rbac\ConsoleModule'
        ]
	],
		
    'params' => $params,
];
