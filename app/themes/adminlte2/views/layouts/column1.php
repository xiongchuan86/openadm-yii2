<?php
\yii\bootstrap\BootstrapAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <!--[if IE 8]> <html lang="<?= Yii::$app->language ?>" class="ie8"> <![endif]-->
    <!--[if IE 9]> <html lang="<?= Yii::$app->language ?>" class="ie8"> <![endif]-->
    <!--[if !IE]><!--> <html lang="<?= Yii::$app->language ?>"> <!--<![endif]-->
<head>
    <title>OpenADM</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <![CDATA[YII-BLOCK-HEAD]]>
</head>
<?php $this->beginBody() ?>
<body>

    <?=$content?>

</body>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
