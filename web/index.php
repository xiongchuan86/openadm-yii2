<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

define('WEB_PATH',__DIR__);
define('APP_PATH',WEB_PATH . "/../app");


require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(APP_PATH . '/config/web.php');

(new yii\web\Application($config))->run();
