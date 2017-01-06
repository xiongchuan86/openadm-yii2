<?php

$config = [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=rm-2ze5bqwi8wy0w0190.mysql.rds.aliyuncs.com;dbname=db_openadm',
            'username' => 'mysql_openadm',
            'password' => 'LOOK@d3qu',
            'charset' => 'utf8',
            'tablePrefix' => 'oa_',
        ],
    ],
];

return $config;
