<?php
use yii\helpers\Html;
use yii\helpers\Url;
use meysampg\treeview\Treeview;
use app\common\SystemConfig;

function formatItem($v){
    $item=[];
    if($v && is_array($v)){
        $item['url']  = isset($v['value']['url']) ? $v['value']['url'] : '#';
        $item['icon']  = isset($v['value']['icon']) ? $v['value']['icon'] : 'fa  fa-angle-right';
        $item['label']= $v['cfg_comment'];
        if(isset($v['active']))$item['active'] = true;
    }
    return $item;
}
//左侧菜单
$sidenav = '';
//生成sidenav需要的items
if(Yii::$app->params[SystemConfig::LEFTMENU_KEY] && is_array(Yii::$app->params[SystemConfig::LEFTMENU_KEY])){
    $items = [];
    foreach (Yii::$app->params[SystemConfig::LEFTMENU_KEY] as $k=>$v){
        if($v['cfg_pid'] == 0){
            $items[$v['id']] = formatItem($v);
        }else{
            continue;
        }
    }
    foreach (Yii::$app->params[SystemConfig::LEFTMENU_KEY] as $k=>$v){
        if($v['cfg_pid']>0){
            if(isset($items[$v['cfg_pid']])){
                if(!isset($items[$v['cfg_pid']]['items'])){
                    $items[$v['cfg_pid']]['items']   = [];
                    $items[$v['cfg_pid']]['items'][$v['id']] = formatItem($v);
                }else{
                    $items[$v['cfg_pid']]['items'][$v['id']] = formatItem($v);
                }
            }else{
                $items[$v['id']] = formatItem($v); //cfg_pid 不正确的情况
            }
        }
    }

    $sidenav = Treeview::widget([
        'clientOptions' => false,
        'encodeLabels' => false,
        'dropDownCaret'=>'<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>',
        'options' => ['class'=>'sidebar-menu'],
        'items' => $items,
    ]);
}

?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <?=$sidenav?>
    </section>
    <!-- /.sidebar -->
</aside>