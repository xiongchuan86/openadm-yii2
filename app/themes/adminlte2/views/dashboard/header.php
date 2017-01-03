<?php
use yii\helpers\Json;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use app\common\Functions;
use app\common\SystemConfig;
?>
<?php if(!Yii::$app->user->isGuest):

    $items = [];
    if(isset(Yii::$app->params[SystemConfig::TOPMENU_KEY])){
        foreach (Yii::$app->params[SystemConfig::TOPMENU_KEY] as $key=>$menu){
            $item = Functions::formatItem($menu);
            $item['linkOptions'] = ['onclick'=>'oa_build_left_menu(this,'.$menu['id'].')'];
            $items[] = $item;
        }
    }
    $nav = Nav::widget([
        'options'=>['class'=>'nav navbar-nav','id'=>'topmenu'],
        'items' => $items,
    ]);
    $leftMenuItems = Json::encode(Yii::$app->params[SystemConfig::LEFTMENU_KEY]);
    $this->registerJs( "var leftMenuItems=". $leftMenuItems,\yii\web\View::POS_HEAD);
    $this->registerJs( '
        
        $(document).ready(function(){
            $("#topmenu").find("li:first a").click();    
            initOpenAdmMenus();
        });
    ',\yii\web\View::POS_END);
    ?>
    <header class="main-header">

        <!-- Logo -->
        <a href="/dashboard" class="logo">
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
                <?=$nav;//顶部导航?>
            </div>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="/static/img/user2-160x160.jpg" class="user-image" alt="User Image">
                            <span class="hidden-xs"><?=Yii::$app->user->displayName?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Menu Footer-->
                            <li><a href="<?=Url::to('/user/profile')?>"><i class="fa fa-user"></i> 个人资料</a></li>
                            <li><a href="<?=Url::to('/user/account')?>"><i class="fa fa-user"></i> 修改密码</a></li>
                            <li><a href="<?=Url::to('/user/logout')?>"><i class="fa fa-off"></i> 退出</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

        </nav>
    </header>
<?php endif;?>