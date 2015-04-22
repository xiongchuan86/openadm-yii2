<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
	
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    	'static/css/bootstrap.min.css',
    	'static/css/style.min.css',
    	'static/css/bootstrap-datetimepicker.css',
    	
    	'static/css/retina.min.css',
    	//'static/css/print.css',
    	
    ];
    public $js = [
    	'static/js/jquery-migrate-1.2.1.min.js',
    	'static/js/bootstrap.min.js',
    	'static/js/custom.min.js',
    	//'static/js/core.min.js',
    	'static/js/uncompressed/core.js',
    	'static/js/jquery.noty.min.js',
    	'static/js/bootstrap-datetimepicker.min.js',
    ];
	public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
