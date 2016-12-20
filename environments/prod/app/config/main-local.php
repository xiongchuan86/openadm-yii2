<?php

$config = [
    'components' => [
        'request' => [
            'enableCsrfValidation' => false,
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
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
    ],
];

return $config;
