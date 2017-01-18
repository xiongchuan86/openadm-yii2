<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\themes\adminlte2\ThemeAsset;
ThemeAsset::register($this);
?>
<?php $this->beginPage() ?>

    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <title><?= Html::encode($this->title) ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="shortcut icon" href="<?=Url::home(true)?>static/ico/favicon.png">
        <?= Html::csrfMetaTags() ?>
        <![CDATA[YII-BLOCK-HEAD]]>
        <script>var User= {login : false};</script>
    </head>
    <body class="hold-transition skin-white layout-top-nav">
        <?php $this->beginBody() ?>

            <div class="wrapper">
                <div class="content-wrapper" style="min-height: 221px;">
                    <div class="container">
                        <!-- Main content -->
                        <?= $this->render('public-content.php',['content'=>$content]) ?>
                        <!-- /.content -->
                    </div>
                    <!-- /.container -->
                </div>
            </div>
        <!-- ./wrapper -->
        <!-- end: JavaScript-->
        <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>