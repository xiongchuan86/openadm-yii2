<?php

$config = [
    'components' => [
        'request' => [
            'enableCsrfValidation' => true,
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'from'  => 'master@openadm.com',
            ],
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.exmail.qq.com',
                'username' => '',
                'password' => '',
                //'port' => '465',
                //'encryption' => 'tls',
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators'=>[
            'model' => ['class' => 'app\modules\gii\generators\model\Generator'],
            'crud' => ['class' => 'app\modules\gii\generators\crud\Generator'],
        ],
    ];
}

return $config;
