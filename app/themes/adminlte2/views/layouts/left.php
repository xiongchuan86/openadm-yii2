<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <?php if(isset(Yii::$app->params['MAINMENU'])  && Yii::$app->params['MAINMENU'])foreach(Yii::$app->params['MAINMENU'] as $menu):
                $cfg_pid = Yii::$app->params['SUBMENU']
                ?>
                <li class="treeview <?php if(isset(Yii::$app->params['CURRENTMENU']['MAINMENU']) && Yii::$app->params['CURRENTMENU']['MAINMENU']==$menu['id']):?> active<?php endif;?>">
                    <a  <?php if(isset(Yii::$app->params['SUBMENU'][$menu['id']])):?>class="dropmenu"<?php endif;?> href="<?php echo Url::to($menu['cfg_value']);?>">
                        <i class="fa <?php echo isset(Yii::$app->params['ICONS'][$menu['cfg_comment']]) ? Yii::$app->params['ICONS'][$menu['cfg_comment']] : 'fa-ellipsis-h';?>"></i>
                        <span class="hidden-sm text"> <?php echo $menu['cfg_comment'];?></span> <?php if(isset(Yii::$app->params['SUBMENU'][$menu['id']])):?><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span><?php endif;?></a>
                    <?php if(isset(Yii::$app->params['SUBMENU'][$menu['id']])):?>
                        <ul class="treeview-menu">
                            <?php foreach(Yii::$app->params['SUBMENU'][$menu['id']] as $k1=>$v1):
                                //var_dump($k1,$v1,Yii::$app->controller->route,strpos("/".Yii::$app->controller->route,$k1));
                                ?>
                                <li <?php if(isset(Yii::$app->params['CURRENTMENU']['SUBMENU']) && Yii::$app->params['CURRENTMENU']['SUBMENU'] == $k1):?>class="active"<?php endif;?>><a class="submenu" href="<?php echo Url::to($k1);?>"><i class="fa fa-chevron-right"></i><span class="hidden-sm text"> <?php echo $v1;?></span></a></li>
                            <?php endforeach;?>
                        </ul>
                    <?php endif;?>
                </li>
            <?php endforeach;?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>