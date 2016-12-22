<?php
use yii\helpers\Url;
use yii\bootstrap\Nav;
use app\common\SystemConfig;


function formatItemForTabs($v){
    $item=[];
    if($v && is_array($v)){
        $item['url']  = isset($v['value']['url']) ? $v['value']['url'] : '#';
        $item['icon'] = isset($v['value']['icon']) ? $v['value']['icon'] : '';
        $item['label']= $v['cfg_comment'];
        if(isset($v['active']))$item['active'] = true;
    }
    return $item;
}
//左侧菜单
$tabs = '';
//生成 tabs 需要的items
if(Yii::$app->params[SystemConfig::INNERMENU_KEY] && is_array(Yii::$app->params[SystemConfig::INNERMENU_KEY])){
    $items = [];
    foreach (Yii::$app->params[SystemConfig::INNERMENU_KEY] as $k=>$v){
        $items[] = formatItemForTabs($v);
    }

    $tabs = Nav::widget(array(
        'options' => ['class' =>'nav-tabs'],
        'items'=>$items
    ));
}

echo $tabs;
?>