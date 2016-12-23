<?php
namespace app\common;
use yii;
use app\models\PluginManager;
use yii\web\Request;
use yii\helpers\Json;
use yii\base\InvalidParamException;

class SystemEvent
{
	const PLUGIN_MODULE_NAME    = "plugin";
    const SYSTEM_TOPMENUID_KEY  = "tmid";
    const SYSTEM_LEFTMENUID_KEY = "lmid";
    const SYSTEM_INNERMENUID_KEY = "imid";
	
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

    /**
     * @return null|Array 菜单
     */
	static public function GetMenus()
    {
        static $_menus = null;
        if($_menus == null){
            $_menus[SystemConfig::TOPMENU_KEY]   = SystemConfig::Get(SystemConfig::TOPMENU_KEY,'',SystemConfig::CONFIG_TYPE_USER);
            $_menus[SystemConfig::LEFTMENU_KEY]  = SystemConfig::Get(SystemConfig::LEFTMENU_KEY,'',SystemConfig::CONFIG_TYPE_USER);
            $_menus[SystemConfig::INNERMENU_KEY] = SystemConfig::Get(SystemConfig::INNERMENU_KEY,'',SystemConfig::CONFIG_TYPE_USER);
        }
        return $_menus;
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
	
	//获取Admin菜单
	static public function GetAdminMenu(){
	    if(self::$hasGetMenu)return;
        $top_menu_id  = Yii::$app->request->get(self::SYSTEM_TOPMENUID_KEY,'');
        $left_menu_id = Yii::$app->request->get(self::SYSTEM_LEFTMENUID_KEY,'');
        $inner_menu_id = Yii::$app->request->get(self::SYSTEM_INNERMENUID_KEY,'');
        //默认获取全部的顶部菜单
        $top_menus  = self::GetCanAccessMenu(SystemConfig::TOPMENU_KEY,'');

        //按条件获取left menu
        $left_menus  = self::GetCanAccessMenu(SystemConfig::LEFTMENU_KEY,$top_menu_id);
        if( $left_menus && is_array($left_menus) && !empty($left_menus)){
            //把top menu id的top menu标记为active
            foreach ($left_menus as $k=>$menu){
                //使用left_menu_id查询当前的menu
                if($menu['id'] == $left_menu_id){
                    $left_menus[$k]['active'] = true;
                    break;//找到后就跳出
                }
                //使用当前的url查询
                if(is_int(strpos("/".Yii::$app->controller->route,$menu['value']['url']))){
                    $left_menus[$k]['active'] = true;
                    $left_menu_id = $left_menus[$k]['id'];
                    break;//找到后就跳出
                }
            }
        }else{
            $left_menu_id = '';//left menu不存在则强制 top menu id为空
        }
        //获取内页的inner menu
        $inner_menus = self::GetCanAccessMenu(SystemConfig::INNERMENU_KEY,'');
        if( $inner_menus && is_array($inner_menus) && !empty($inner_menus)){

            //把inner menu id的inner menu标记为active
            foreach ($inner_menus as $k=>$menu){
                //使用当前的url查询
                if(is_int(strpos("/".Yii::$app->request->pathInfo,$menu['value']['url']))){
                    $inner_menus[$k]['active'] = true;
                    $inner_menu_id = $inner_menus[$k]['id'];
                    $left_menu_id  = $inner_menus[$k]['cfg_pid'];
                    //重新刷新left menu的active id
                    foreach($left_menus as $_k=>$_v){
                        if($_v['id'] == $left_menu_id){
                            $left_menus[$_k]['active'] = true;
                            $top_menu_id = $_v['cfg_pid'];//从left menu获取top menu id
                        }else{
                            unset($left_menus[$_k]['active']);
                        }
                    }
                    //----
                    break;//找到后就跳出
                }
            }
        }

        if($inner_menus && !empty($inner_menus))foreach ($inner_menus as $_k=>$_v){
            if($_v['cfg_pid'] != $left_menu_id){
                unset($inner_menus[$_k]);
            }
        }
        //重新设置top menu的active id
        if($top_menu_id>0 && !empty($top_menus)){
            foreach ($top_menus as $_k=>$_v){
                if($_v['cfg_pid'] != $top_menu_id){
                    $top_menus[$_k]['active'] = true;
                }else{
                    unset($top_menus[$_k]['active']);
                }
            }
        }

        Yii::$app->params[SystemConfig::TOPMENU_KEY]   = $top_menus;
        Yii::$app->params[SystemConfig::LEFTMENU_KEY]  = $left_menus;
        Yii::$app->params[SystemConfig::INNERMENU_KEY] = $inner_menus;

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
