<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<!-- start: Meta -->
	<meta charset="<?= Yii::$app->charset ?>">
	<title><?= Html::encode($this->title) ?></title>
	<meta name="description" content="yetcms">
	<meta name="author" content="xiongchuan86@vip.qq.com">
	<meta name="keyword" content="yetcms">
	<!-- end: Meta -->
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->
	<!-- start: CSS -->
	<link href="<?=Url::home(true)?>static/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?=Url::home(true)?>static/css/style.min.css" rel="stylesheet">
	<link href="<?=Url::home(true)?>static/css/retina.min.css" rel="stylesheet">
	<link href="<?=Url::home(true)?>static/css/print.css" rel="stylesheet" type="text/css" media="print"/>
	<!-- end: CSS -->
	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script src="<?=Url::home(true)?>static/js/respond.min.js"></script>
	<![endif]-->
	<!-- start: Favicon and Touch Icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?=Url::home(true)?>static/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?=Url::home(true)?>static/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?=Url::home(true)?>static/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?=Url::home(true)?>static/ico/apple-touch-icon-57-precomposed.png">
	<link rel="shortcut icon" href="<?=Url::home(true)?>static/ico/favicon.png">
	<!-- end: Favicon and Touch Icons -->	
</head>
<body>
	<?php $this->beginBody() ?>
	<?php if(!Yii::$app->user->isGuest):?>
		<!-- start: Header -->
	<header class="navbar">
		<div class="container">
			<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".sidebar-nav.nav-collapse">
			      <span class="icon-bar"></span>
			      <span class="icon-bar"></span>
			      <span class="icon-bar"></span>
			</button>
			<a id="main-menu-toggle" class="hidden-xs open"><i class="fa fa-bars"></i></a>		
			<a class="navbar-brand col-md-2 col-sm-1 col-xs-2" href="index.html"><span><?= Html::encode(Yii::$app->name) ?></span></a>
			<!-- start: Header Menu -->
			<div class="nav-no-collapse header-nav">
				<ul class="nav navbar-nav pull-right">
					
					<!-- start: User Dropdown -->
					<li class="dropdown">
						<a class="btn account dropdown-toggle" data-toggle="dropdown" href="index.html#">
							<div class="avatar"><img src="<?=Url::home(true)?>static/img/avatar.jpg" alt="Avatar"></div>
							<div class="user">
								<span class="hello">Welcome!</span>
								<span class="name"><?=Yii::$app->user->displayName?></span>
							</div>
						</a>
						<ul class="dropdown-menu">
							<li><a href="<?=Url::to('/user/profile')?>"><i class="fa fa-user"></i> 个人资料</a></li>
							<li><a href="<?=Url::to('/user/account')?>"><i class="fa fa-user"></i> 修改密码</a></li>
							<li><a href="<?=Url::to('/user/logout')?>"><i class="fa fa-off"></i> 退出</a></li>
						</ul>
					</li>
					<!-- end: User Dropdown -->
				</ul>
			</div>
			<!-- end: Header Menu -->
		</div>	
	</header>
	<!-- end: Header -->
	<?php endif;?>
	<div class="container">
	<?php echo $content;?>
	</div><!--/container-->
	<?php if(!Yii::$app->user->isGuest):?>
	<div class="clearfix"></div>
	<footer>
		<div class="row">
			<div class="col-sm-5">
				&copy; 2015 YetCMS.COM
			</div><!--/.col-->
		</div><!--/.row-->	
	</footer>
	<?php endif;?>
	<!-- end: JavaScript-->
	<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>