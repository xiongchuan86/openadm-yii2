<?php
use yii\helpers\Json;
use yii\helpers\Html;
use yii\helpers\Url;
use app\themes\adminlte2\ThemeAsset;
ThemeAsset::register($this);

$this->registerJs( "var OA_Menus=". Json::encode($menus),\yii\web\View::POS_HEAD);
$checkWindowJs = '';
if(!Yii::$app->user->isGuest){
    $checkWindowJs = 'checkTopWindow();';
}
$this->registerJs( '
        
        $(document).ready(function(){
            oa_build_top_menu();
            $("#topmenu").find("li:first a").click();
        });
        window.onMenuChange = function(id){oa_update_menu(id);};
        '.$checkWindowJs.'
    ',\yii\web\View::POS_END);
?>
<?php $this->beginPage() ?>

    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <title><?= Html::encode($this->title) ?></title>
        <meta name="description" content="OpenAdm是一个基于Yii2的后台开源骨架，集成了用户和插件系统,使用主题功能,默认使用AdminLTE2的模板的主题,可以非常方便的开发新的功能。">
        <meta name="author" content="xiongchuan86@gmail.com">
        <meta name="keyword" content="openadmin,admin,yii2,adminlte,rbac">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?= Html::csrfMetaTags() ?>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <link rel="shortcut icon" href="<?=Url::home(true)?>static/ico/favicon.png">
        <![CDATA[YII-BLOCK-HEAD]]>
    </head>

    <?php if(!Yii::$app->user->isGuest):?>
    <body  class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->beginBody() ?>
        <?= $this->render('header.php') ?>
        <?= $this->render('left.php') ?>
        <?= $this->render('content.php') ?>
        <?php endif;?>


        <?php if(0 && !Yii::$app->user->isGuest):?>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    Powered by <strong><a href="http://openadm.com" target="_blank">OpenADM.Com</a>.</strong> <b>Version</b> <?=\app\common\SystemConfig::getVersion()?>
                </div>
                <strong>Copyright &copy; 2016-2017 <a href="http://openadm.com" target="_blank"><?=Yii::$app->name?></a>.</strong> All rights
                reserved.
            </footer>
        <?php endif;?>

    </div>
    <!-- ./wrapper -->
    <?php if(!Yii::$app->user->isGuest):?>
        <?php
        echo $this->render('noty.default.php')
        ?>
    <?php endif;?>
    <!-- end: JavaScript-->
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>