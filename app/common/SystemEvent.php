<?php
namespace app\common;

use yii;
use yii\base\Component;
use yii\web\Request;
use yii\helpers\Json;
use yii\base\InvalidParamException;

class SystemEvent extends Component
{

    static public function beforeRequest()
    {
        self::AddUrlRules();
    }

    static public function AddUrlRules()
    {
        $routes = SystemConfig::Get("",null,'ROUTE');
        if($routes){
            $rules = [];
            foreach($routes as $route){
                $tmp = explode("=>", $route['cfg_value']);
                if(2 == count($tmp))
                    $rules[$tmp[0]] = $tmp[1];
            }
            if($rules)Yii::$app->urlManager->addRules($rules);
        }
    }

    /**
     * 获取菜单项,并且通过权限过滤
     * @param $key system_config的cfg_key
     * @param $pid system_config的id
     */
    static public function GetCanAccessMenu($key,$pid)
    {
        $menus = SystemConfig::Get($key,$pid,SystemConfig::CONFIG_TYPE_USER);
        if(is_array($menus) && !empty($menus)){
            foreach ($menus as $k=>$menu){
                try{
                    $value = Json::decode($menu['cfg_value'],true);
                    if(isset($value['url'])){//必须要有url字段
                        if(!self::CheckAccessMenu($value['url']))unset($menus[$k]);
                        else{
                            $menus[$k]['value'] = $value;
                        }
                    }
                }catch (InvalidParamException $e){
                    continue;
                }

            }
        }
        return $menus;
    }

    static public function FortmatMenus($menus,$pid=0)
    {
        $items = [];
        if(is_array($menus) && !empty($menus)){
            foreach ($menus as $k=>$menu){
                if($menu['cfg_pid']==$pid){
                    $_menu = [];
                    $_menu['content'] = $menu;
                    $submenus = self::FortmatMenus($menus,$menu['id']);
                    if(!empty($submenus))
                        $_menu['items'] = $submenus;
                    $items[] = $_menu;
                }
            }
        }
        return $items;
    }


    //获取Admin菜单
    static public function GetAdminMenu(){
        //默认获取全部的菜单
        $menus  = self::GetCanAccessMenu(SystemConfig::MENU_KEY,'');

        return  self::FortmatMenus($menus);
    }

    /**
     * 通过url获取route,通过rule解析得到
     */
    static public function GetRouteFromUrl($url)
    {
        $action = $controller = $module = $plugin = null;
        if(Yii::$app->urlManager->rules)foreach(Yii::$app->urlManager->rules as $rule){
            $request = new Request;
            $request->pathinfo = $url;
            $request->hostinfo = "http://127.0.0.1";
            list($route,$params) = $rule->parseRequest(Yii::$app->urlManager,$request);
            if($route){
                list($id,$route) = explode("/",trim($route,"/"),2);
                if(isset(Yii::$app->modules[$id]) || array_search($id,Yii::$app->modules)){
                    $module     = $id;
                    if($module == 'plugin'){
                        $array      = explode("/", trim($route,"/"),3);
                        $plugin     = !empty($array[0]) ? $array[0] : null;
                        $controller = !empty($array[1]) ? $array[1] : null;
                        $action     = !empty($array[2]) ? $array[2] : null;
                    }else{
                        $array      = explode("/", trim($route,"/"),3);
                        $controller = !empty($array[0]) ? $array[0] : null;
                        $action     = !empty($array[1]) ? $array[1] : null;
                    }
                }else{
                    $controller = $id;
                    $action     = explode("/", trim($route,"/"),2)[0];
                }
            }else{
                $array = explode("/", trim($url,"/"));
                $module     = !empty($array[0]) ? $array[0] : null;
                $plugin     = !empty($array[1]) ? $array[1] : null;
                $controller = !empty($array[2]) ? $array[2] : null;
                $action     = !empty($array[3]) ? $array[3] : null;

                //fixed 中间冒号的方式进入文件夹
                $plugin = str_replace(":","/",$plugin);
                if($module == 'plugin'){
                    if($action == null){
                        //plugin/menu/menuController的情况
                        $action     = $controller;
                        $controller = $plugin;
                    }
                }
            }
        }
        return ['action'=>$action,'controller'=>$controller,'module'=>$module,'plugin'=>$plugin];
    }

    /**
     * 判断菜单的权限
     */
    static public function CheckAccessMenu($url)
    {
        if($url == "#")return true;
        $request = self::GetRouteFromUrl($url);
        $m = empty($request['module']) ? "" : $request['module'] ;
        $p = empty($request['plugin']) ? "" : $request['plugin'] ;
        $c = empty($request['controller']) ? "" : $request['controller'] ;
        $a = empty($request['action']) ? "" : $request['action'];
        $user = Yii::$app->getUser();
        if($p){
            $route = "/{$m}/{$p}/{$c}/{$a}";
            if($user->can(str_replace("//", "/",$route),[],true))return true;//check action
            $route = "/{$m}/{$p}/{$c}/*";
            if($user->can(str_replace("//", "/",$route),[],true))return true;//check controller
            $route = "/{$m}/{$p}/*";
            if($user->can(str_replace("//", "/",$route),[],true))return true;//check plugin
        }else{
            $route = "/{$m}/{$c}/{$a}";
            if($user->can(str_replace("//", "/",$route),[],true))return true;//check action
            $route = "/{$m}/{$c}/*";
            if($user->can(str_replace("//", "/",$route),[],true))return true;//check controller
        }
        $route = "/{$m}/*";
        if($user->can(str_replace("//", "/",$route),[],true))return true;//check module
        return false;
    }

}
