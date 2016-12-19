<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Alert;
use app\modules\noty\Wrapper;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\themes\adminlte2\ThemeAsset;
ThemeAsset::register($this);
?>
<?php $this->beginPage() ?>

    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <title><?= Html::encode($this->title) ?></title>
        <meta name="description" content="yetcms">
        <meta name="author" content="xiongchuan86@vip.qq.com">
        <meta name="keyword" content="yetcms">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel="shortcut icon" href="<?=Url::home(true)?>static/ico/favicon.png">
        <![CDATA[YII-BLOCK-HEAD]]>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->beginBody() ?>

        <?= $this->render('header.php') ?>

        <?= $this->render('left.php') ?>

        <?= $this->render('content.php',['content'=>$content]) ?>

        <?php if(!Yii::$app->user->isGuest):?>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    Powered by <strong><a href="http://openadm.com" target="_blank">Openadm.Com</a>.</strong> <b>Version</b> <?=\app\common\SystemConfig::getVersion()?>
                </div>
                <strong>Copyright &copy; 2016-2017 <a href="http://openadm.com" target="_blank"><?=Yii::$app->name?></a>.</strong> All rights
                reserved.
            </footer>
        <?php endif;?>

    </div>
    <!-- ./wrapper -->
    <?php
    //for notification
    echo Wrapper::widget([
        'layerClass' => 'lo\modules\noty\layers\Noty',
        'layerOptions'=>[
            // for every layer (by default)
            'layerId' => 'noty-layer',
            'customTitleDelimiter' => '|',
            'overrideSystemConfirm' => true,
            'showTitle' => true,
        ],

        // clientOptions
        'options' => [
            'dismissQueue' => true,
            'layout' => 'topRight',
            'timeout' => 1000,
            'theme' => 'relax',
        ],
    ]);

    ?>
	<!-- end: JavaScript-->
	<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>