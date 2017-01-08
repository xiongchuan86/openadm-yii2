<?php
namespace app\modules\admin\controllers;

use Yii;
use app\common\Controller;
use app\common\SystemConfig;
use app\modules\admin\models\PluginManager;

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
		return $this->render("local",['tab'=>$tab,'result'=>$result]);
	}
	
	public function actionShop()
	{
		$url = $this->plugin_center_url.'/plugins/token/'.Yii::app()->params['token'];
		$this->render("shop",array('url'=>$url));
	}

	//iframe for long request
	public function actionAjax()
	{
        if(Yii::$app->request->isPost){
            $action   = Yii::$app->request->post('action','');
            $pluginid = Yii::$app->request->post('pluginid','');
            if($pluginid && $action && in_array($action,['setup','unsetup','delete'])){
                PluginManager::setShowMsg(1);
                $result = PluginManager::$action($pluginid);
                PluginManager::setShowMsg(0);
                //update  systemconfig
                SystemConfig::cache_flush();
            }
        }
	}


}