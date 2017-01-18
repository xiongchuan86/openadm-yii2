<?php
use yii\helpers\Url;
?>
<?php if(!Yii::$app->user->isGuest):?>
    <header class="main-header">

        <!-- Logo -->
        <a href="/admin/dashboard" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>ADM</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">Open<b>ADM</b></span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">

            </div>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="hidden-xs"><?=Yii::$app->user->displayName?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Menu Footer-->
                            <li><a data-id="10001" class="openlink" href="<?=Url::to('/user/admin/profile')?>"><i class="fa fa-user"></i> 个人资料</a></li>
                            <li><a data-id="10002" class="openlink" href="<?=Url::to('/user/admin/account')?>"><i class="fa fa-user"></i> 修改密码</a></li>
                            <li><a href="<?=Url::to('/user/admin/logout')?>"><i class="fa  fa-sign-out"></i> 退出</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

        </nav>
    </header>
<?php endif;?>