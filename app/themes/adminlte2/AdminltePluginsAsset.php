<?php
/**
 * Created by PhpStorm.
 * User: xiongchuan
 * Date: 2017/1/1
 * Time: 下午12:10
 */
namespace app\themes\adminlte2;
use yii\web\AssetBundle;
class AdminltePluginsAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins';
    public $js = [
        'fastclick/fastclick.js',
    ];
    public $css = [
    ];
    public $depends = [
        'dmstr\web\AdminLteAsset',
    ];
}