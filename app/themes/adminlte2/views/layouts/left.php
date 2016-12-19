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
                ?>
                <li class="treeview <?php if(isset(Yii::$app->params['CURRENTMENU']['MAINMENU']) && Yii::$app->params['CURRENTMENU']['MAINMENU']==$menu['id']):?> active<?php endif;?>">
                    <a  <?php if(isset(Yii::$app->params['SUBMENU'][$menu['id']])):?>class="dropmenu"<?php endif;?> href="<?php echo Url::to($menu['cfg_value']);?>">
                        <i class="fa <?php echo isset(Yii::$app->params['ICONS'][$menu['cfg_comment']]) ? Yii::$app->params['ICONS'][$menu['cfg_comment']] : 'fa-ellipsis-h';?>"></i>
                        <span class="hidden-sm text"> <?php echo $menu['cfg_comment'];?></span> <?php if(isset(Yii::$app->params['SUBMENU'][$menu['id']])):?><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span><?php endif;?></a>
                    <?php if(isset(Yii::$app->params['SUBMENU'][$menu['id']])):?>
                        <ul class="treeview-menu">
                            <?php foreach(Yii::$app->params['SUBMENU'][$menu['id']] as $key=>$val):
                                $url   = $val['cfg_value'];
                                ?>
                                <li <?php if(isset(Yii::$app->params['CURRENTMENU']['SUBMENU']) && Yii::$app->params['CURRENTMENU']['SUBMENU'] == $val['id']):?>class="active"<?php endif;?>><a class="submenu" href="<?php echo Url::to([$url,'pid'=>$val['id']]);?>"><i class="fa fa-chevron-right"></i><span class="hidden-sm text"> <?php echo $val['cfg_comment'];?></span></a></li>
                            <?php endforeach;?>
                        </ul>
                    <?php endif;?>
                </li>
            <?php endforeach;?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>