<?php
namespace app\common;

use yii;
class Functions
{
    //for menu/nav items
    static function formatItem($v){
        $item=[];
        if($v && is_array($v)){
            $item['url']  = isset($v['value']['url']) ? $v['value']['url'] : '#';
            $item['icon']  = isset($v['value']['icon']) && !empty($v['value']['icon'])? $v['value']['icon'] : 'fa  fa-angle-right';
            $item['label']= $v['cfg_comment'];
            if(isset($v['active']))$item['active'] = true;
        }
        return $item;
    }

    static function genMenuItems($menu_key)
    {
        $items = [];
        if( isset(Yii::$app->params[$menu_key]) && Yii::$app->params[$menu_key] && is_array(Yii::$app->params[$menu_key])){

            foreach (Yii::$app->params[$menu_key] as $k=>$v){
                if($v['cfg_pid'] == 0){
                    $items[$v['id']] = static::formatItem($v);
                }else{
                    continue;
                }
            }
            foreach (Yii::$app->params[$menu_key] as $k=>$v){
                if($v['cfg_pid']>0){
                    if(isset($items[$v['cfg_pid']])){
                        if(!isset($items[$v['cfg_pid']]['items'])){
                            $items[$v['cfg_pid']]['items']   = [];
                            $items[$v['cfg_pid']]['items'][$v['id']] = static::formatItem($v);
                        }else{
                            $items[$v['cfg_pid']]['items'][$v['id']] = static::formatItem($v);
                        }
                    }else{
                        $items[$v['id']] = static::formatItem($v); //cfg_pid 不正确的情况
                    }
                }
            }

        }
        return $items;
    }

}