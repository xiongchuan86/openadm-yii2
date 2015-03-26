<?php

namespace app\modules\plugin;
use yii;
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\plugin\controllers';

    public function init()
    {
        parent::init();
        
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
		$pluginid = strtolower(Yii::$app->controller->id);
		$path = dirname(__FILE__).DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.$pluginid.DIRECTORY_SEPARATOR.'views';
		if(is_dir($path))
			$this->setViewPath($path);
	}
}
