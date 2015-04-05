<?php
namespace app\modules\plugin\src\hello;
use app\modules\plugin\components\PluginBaseController;
class HelloController extends PluginBaseController
{
	
	public function actionIndex()
	{
		return $this->render("index");
	}
	
	public function actionVideo()
	{
		return $this->render("index");
	}
}
