<?php

namespace app\modules\plugin;
use yii;
class Module extends \yii\base\Module
{
    public $controllerNamespace = '';

	public $pluginid = "";
	
    public function init()
    {
        parent::init();
        //reset controllerNamespace
        $route = Yii::$app->requestedRoute;
		$array = explode("/",trim($route,"/"));
		$this->pluginid = $array[1];
        $this->controllerNamespace = 'app\modules\plugin\src\\' . strtolower($this->pluginid) ;
    }
	
	public function beforeAction($action)
	{
		$this->setPluginViewPath();
	    if (!parent::beforeAction($action)) {
	        return false;
	    }
	
	    return true; // or false to not run the action
	}
	
	public function setPluginViewPath()
	{
		$path = dirname(__FILE__).DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.$this->pluginid.DIRECTORY_SEPARATOR.'views';
		if(is_dir($path)){
			$this->setViewPath($path);
			Yii::setAlias("@pluginView",$path);
		}
			
	}
}
