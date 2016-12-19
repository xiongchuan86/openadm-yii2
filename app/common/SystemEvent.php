<?php
namespace app\common;
use yii;
use app\models\PluginManager;
use yii\web\Request;

class SystemEvent
{
	const PLUGIN_MODULE_NAME = "plugin";
	
	static private $requestedPlugin = false;

    static private $hasGetMenu         = false;
	
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
	
	static public function beforeAction()
	{
		self::GetRequestedPlugin();
		if( self::$requestedPlugin){
			$plugin_type = isset(self::$requestedPlugin['config']['type']) ? self::$requestedPlugin['config']['type'] : '';
			if($plugin_type == PluginManager::PLUGIN_TYPE_ADMIN) self::GetAdminMenu();
		}else{
			if(in_array(Yii::$app->controller->module->id,['rbac']))self::GetAdminMenu();
		}
		self::Authenticate();
		self::GetAdminMenu();
	}
	
	static public function Authenticate()
	{
		//
	}
	
	//读取当前请求的插件信息
	static public function GetRequestedPlugin()
	{
		if(self::PLUGIN_MODULE_NAME == strtolower(Yii::$app->controller->module->id))
		{
			//读取插件信息
			self::$requestedPlugin = PluginManager::GetPluginConfig(strtolower(Yii::$app->controller->id),false,null,false);
		}
	}
	
	//获取Admin菜单
	static public function GetAdminMenu(){
	    if(self::$hasGetMenu)return;
		//获取主菜单
		Yii::$app->params['MAINMENU']   = SystemConfig::Get("MAINMENU",null,'USER');
		//获取子菜单
		$submenus    = array();
		foreach(Yii::$app->params['MAINMENU'] as $i=>$menu){
			if(!self::CheckAccessMenu($menu['cfg_value']))unset(Yii::$app->params['MAINMENU'][$i]);
            //判断当前主菜单是否为active
            if(is_int(strpos("/".Yii::$app->controller->route,$menu['cfg_value']))){
                Yii::$app->params['CURRENTMENU'] = array(
                    'MAINMENU' => $menu['id'],
                );
            }
			$submenu = SystemConfig::Get("SUBMENU",$menu['id'],'USER');
			if(!empty($submenu)){
				foreach($submenu as $key=>$val){
				    $url   = $val['cfg_value'];
                    $label = $val['cfg_comment'];
					if(!self::CheckAccessMenu($url))unset($submenu[$key]);
                    //判断当前子菜单是否为active
                    if(is_int(strpos("/".Yii::$app->controller->route,$url))){
                        Yii::$app->params['CURRENTMENU'] = array(
                            'MAINMENU' => $menu['id'],
                            'SUBMENU'  => $val['id']
                        );
                    }
				}
				if(!empty($submenu))
					$submenus[$menu['id']] = $submenu;
				if(!isset($submenus[$menu['id']]) || empty($submenus[$menu['id']]))
					unset(Yii::$app->params['MAINMENU'][$i]);

			}
		}	
		Yii::$app->params['SUBMENU'] = $submenus;	
		//获取ICONS
		Yii::$app->params['ICONS']      = SystemConfig::GetArrayValue("ICONS",null,'USER');
        self::$hasGetMenu = true;
	}
	
	/**
	 * 通过url获取route,通过rule解析得到
	 */
	static public function GetRouteFromUrl($url)
	{
		$action = $controller = $module = null;
		if(Yii::$app->urlManager->rules)foreach(Yii::$app->urlManager->rules as $rule){
			$request = new Request;
			$request->pathinfo = $url;
			$request->hostinfo = "http://127.0.0.1";
			list($route,$params) = $rule->parseRequest(Yii::$app->urlManager,$request);
			if($route){
				list($id,$route) = explode("/",trim($route,"/"),2);
				if(isset(Yii::$app->modules[$id]) || array_search($id,Yii::$app->modules)){
					$module     = $id;
					$array      = explode("/", trim($route,"/"),3);
					$controller = !empty($array[0]) ? $array[0] : null;
					$action     = !empty($array[1]) ? $array[1] : null;
				}else{
					$controller = $id;
					$action     = explode("/", trim($route,"/"),2)[0];
				}
			}else{
				$array = explode("/", trim($url,"/"));
				$module     = !empty($array[0]) ? $array[0] : null;
				$controller = !empty($array[1]) ? $array[1] : null;
				$action     = !empty($array[2]) ? $array[2] : null;
			}
		}
		return ['action'=>$action,'controller'=>$controller,'module'=>$module];
	}
	
	/**
	 * 判断菜单的权限
	 */
	static public function CheckAccessMenu($url)
	{
		if($url == "#")return true;
		$request = self::GetRouteFromUrl($url);
		$m = empty($request['module']) ? "" : $request['module'] ;
		$c = empty($request['controller']) ? "" : $request['controller'] ;
		$a = empty($request['action']) ? "" : $request['action'];
        $user = Yii::$app->getUser();
		$route = "/{$m}/{$c}/{$a}";
		if($user->can(str_replace("//", "/",$route)))return true;//check action
		$route = "/{$m}/{$c}/*";
		if($user->can(str_replace("//", "/",$route)))return true;//check controller
		$route = "/{$m}/*";
		if($user->can(str_replace("//", "/",$route)))return true;//check module
		return false;
	}
	
}
