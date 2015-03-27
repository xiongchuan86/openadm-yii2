<?php
namespace app\common;
use yii;
use app\models\Mplugin;

class SystemEvent
{
	const PLUGIN_MODULE_NAME = "plugin";
	
	static private $requestedPlugin = false;
	
	static public function beforeRequest()
	{
		Yii::setAlias('@bower', Yii::$app->vendorPath . DIRECTORY_SEPARATOR . 'bower-asset');
		
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
			if($plugin_type == Mplugin::PLUGIN_TYPE_ADMIN) self::GetAdminMenu();
		}else{
			if(in_array(Yii::$app->controller->module->id,['rbac']))self::GetAdminMenu();
		}
		self::Authenticate();
		
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
			self::$requestedPlugin = Mplugin::GetPluginConfig(strtolower(Yii::$app->controller->id),false,null,false);
		}
	}
	
	//获取Admin菜单
	static public function GetAdminMenu(){
		//获取主菜单
		Yii::$app->params['MAINMENU']   = SystemConfig::Get("MAINMENU",null,'USER');
		
		//获取子菜单
		$submenus    = array();
		foreach(Yii::$app->params['MAINMENU'] as $menu){
			$submenu = SystemConfig::GetArrayValue("SUBMENU",$menu['id'],'USER');
			if(!empty($submenu)){
				$submenus[$menu['id']] = $submenu;
			}
		}	
		Yii::$app->params['SUBMENU'] = $submenus;	
		//获取ICONS
		Yii::$app->params['ICONS']      = SystemConfig::GetArrayValue("ICONS",null,'USER');
	}
	
}
