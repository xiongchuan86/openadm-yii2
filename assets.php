<?php
/**
 * Configuration file for the "yii asset" console command.
 */

// In the console environment, some path aliases may not exist. Please define these:
// Yii::setAlias('@webroot', __DIR__ . '/../web');
// Yii::setAlias('@web', '/');
include 'app/config/bootstrap.php';

return [
    // Adjust command/callback for JavaScript files compressing:
    'jsCompressor' => 'java -jar closure-compiler-v20161201.jar --js {from} --js_output_file {to}',
    // Adjust command/callback for CSS files compressing:
    'cssCompressor' => 'java -jar yuicompressor-2.4.8.jar --type css {from} -o {to}',
    // Whether to delete asset source after compression:
    'deleteSource' => false,
    // The list of asset bundles to compress:
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
    // Asset bundle for compression output:
    'targets' => [
        'all' => [
            'class' => 'yii\web\AssetBundle',
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets',
            'js' => 'all-{hash}.js',
            'css' => 'all-{hash}.css',
        ],
    ],
    // Asset manager configuration:
    'assetManager' => [
        'basePath' => '@webroot/static/assets',
        'baseUrl' => '@web/static/assets',
        'bundles'=> [
            'dmstr\web\AdminLteAsset'=>[
                'class'=>'dmstr\web\AdminLteAsset',
                'skin'=>'skin-blue'
            ]
        ]
    ],
];