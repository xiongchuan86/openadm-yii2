<?php

$params = array_merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

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
    ],
    'modules' => [
	    'gii' => 'yii\gii\Module',
        'rbac' => [
            'class' => 'yii2mod\rbac\ConsoleModule',
            'controllerMap'=>[
                'migrate' => [
                    'class'          => 'yii2mod\rbac\commands\MigrateController',
                    'migrationTable' => '{{%migration}}',
                    'migrationPath'  => '@app/migrations'
                ]


            ],
        ]
	],
		
    'params' => $params,
];
