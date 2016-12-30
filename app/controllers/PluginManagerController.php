<?php
namespace app\controllers;

use Yii;
use app\common\Controller;
use app\common\SystemConfig;
use app\models\PluginManager;
use app\common\SystemEvent;

class PluginManagerController extends Controller
{
    public $defaultAction = 'local';

    private $plugin_center_url = "http://api.openadm.com";

	//plugin list
	public function actionIndex()
	{
		$this->redirect("local");
	}
	
	public function actionLocal($tab = "all",$page=1)
	{
		$tab = in_array($tab,array('all','setuped','new')) ? $tab : 'all';
		//获取插件
		$pageSize = 20;
		$result = PluginManager::GetPlugins($tab,$page,$pageSize);
		return $this->render("local",array('tab'=>$tab,'result'=>$result));
	}
	
	public function actionShop()
	{
		$url = $this->plugin_center_url.'/plugins/token/'.Yii::app()->params['token'];
		$this->render("shop",array('url'=>$url));
	}


	//ajax
	public function actionAjax()
	{
		$result = array(
			'status'=>0,
			'msg'=>'缺少参数'
		);
		if(!empty($_POST)){
			$action = isset($_POST['action']) ? $_POST['action'] : '';
			$pluginid = isset($_POST['pluginid']) ? $_POST['pluginid'] : '';
			if($pluginid && $action){
				$result = PluginManager::$action($pluginid);
			}
		}
		echo json_encode($result);
	}

}