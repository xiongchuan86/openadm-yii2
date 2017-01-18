<?php
/**
 * Configuration file for the "yii asset" console command.
 */

// In the console environment, some path aliases may not exist. Please define these:
// Yii::setAlias('@webroot', __DIR__ . '/../web');
// Yii::setAlias('@web', '/');
include 'app/config/bootstrap.php';

return [
    'jsCompressor' => 'gulp compress-js --gulpfile tools/gulp/gulpfile.js --src {from} --dist {to}',
    'cssCompressor' => 'gulp compress-css --gulpfile tools/gulp/gulpfile.js --src {from} --dist {to}',
    // Whether to delete asset source after compression:
    'deleteSource' => false,
    // The list of asset bundles to compress:
    // Asset bundle for compression output:
    'bundles' => [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
        'app\themes\adminlte2\AdminltePluginsAsset',
        'app\plugins\menu\assets\MenuAsset',
        'app\themes\adminlte2\ThemeAsset',
        'nirvana\showloading\ShowLoadingAsset',
        'app\themes\adminlte2\AdminLteAsset',
        'app\themes\adminlte2\ShowLoadingAsset',
        'lo\modules\noty\assets\NotyAsset'
    ],
    'targets' => [
        'allShared' => [
            'class' => 'yii\web\AssetBundle',
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets',
            'js' => 'all-shared-{hash}.js',
            'css' => 'all-shared-{hash}.css',
            'depends' => [
                'yii\bootstrap\BootstrapAsset',
                'yii\bootstrap\BootstrapPluginAsset',
                'rmrevin\yii\fontawesome\AssetBundle',
                'yii\web\JqueryAsset',
            ],
        ],
        'allBackEnd' => [
            'class' => 'yii\web\AssetBundle',
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets',
            'js' => 'all-backend-{hash}.js',
            'css' => 'all-backend-{hash}.css',
            'depends' => [
                'yii\web\YiiAsset',
                'yii\jui\JuiAsset',
                'app\themes\adminlte2\AdminltePluginsAsset',
                'app\plugins\menu\assets\MenuAsset',
                'app\themes\adminlte2\ThemeAsset',
                'nirvana\showloading\ShowLoadingAsset',
                'app\themes\adminlte2\AdminLteAsset',
                'app\themes\adminlte2\ShowLoadingAsset',
                'lo\modules\noty\assets\NotyAsset'
            ],
        ],
        'allFrontEnd' => [
            'class' => 'yii\web\AssetBundle',
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets',
            'js' => 'all-frontend-{hash}.js',
            'css' => 'all-frontend-{hash}.css',
            'depends' => [

            ],
        ],
    ],
    // Asset manager configuration:
    'assetManager' => [
        'basePath' => '@webroot/static/assets',
        'baseUrl' => '@web/static/assets',
    ],
];