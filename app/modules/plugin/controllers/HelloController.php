<?php
namespace app\modules\plugin\controllers;
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
