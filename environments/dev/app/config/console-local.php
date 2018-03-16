<?php
return [
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'controllerMap' => [
        'migration' => [
            'class' => 'bizley\migration\controllers\MigrationController',
        ],
    ],
];