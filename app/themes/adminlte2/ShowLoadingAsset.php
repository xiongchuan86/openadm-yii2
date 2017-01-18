<?php
/**
 * @link https://github.com/nirvana-msu/yii2-showloading
 * @copyright Copyright (c) 2014 Alexander Stepanov
 * @license MIT
 */

namespace app\themes\adminlte2;

use Yii;
use yii\web\AssetBundle;

/**
 * @author Alexander Stepanov <student_vmk@mail.ru>
 */
class ShowLoadingAsset extends AssetBundle
{
    public $sourcePath = '@vendor/nirvana-msu/yii2-showloading/assets';
    public $css = [
        'css/showLoading.css',
    ];
    public $js = [
        'js/jquery.showLoading.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        parent::init();
    }
}
