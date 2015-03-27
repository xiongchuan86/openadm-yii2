<?php
namespace app\modules\rbac\assets;

use yii\web\AssetBundle;


/**
 * Class RbacAsset
 * @package yii2mod\rbac\assets
 */
class RbacAsset extends AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = '@app/modules/rbac/assets';


    /**
     * @var array
     */
    public $js = [
        'js/rbac.js'
    ];

    public $css = [
        'css/rbac.css',
    ];
    
    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
