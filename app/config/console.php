<?php

$params = array_merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'openadm-console',
    'bootstrap' => ['log', 'gii'],
    'basePath' => '@app',
    'vendorPath' => '@vendor',
    'runtimePath' => '@runtime',
    'controllerNamespace' => 'app\console',
    'controllerMap' => [
        'migrate' => [
            'class' => 'app\console\MigrateController'
        ]
    ],
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
    ],
    'modules' => [
	    'gii' => 'yii\gii\Module',
	],
		
    'params' => $params,
];
