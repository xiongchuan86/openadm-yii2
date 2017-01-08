<?php

namespace app\modules\admin\controllers;

use yii;
use yii\helpers\Json;
use app\common\Controller;
use app\common\SystemEvent;

class DashboardController extends Controller
{
    public $defaultAction = 'index';
	public function init()
	{
		parent::init();
		
	}
	
    public function actionMain()
    {
        return $this->render('main');
    }

    public function actionIndex()
    {
        $menus = SystemEvent::GetAdminMenu();
        if(Yii::$app->request->isAjax){
            return '<script>OA_Menus='.Json::encode($menus).'</script>';
        }
        return $this->renderPartial('index',['menus'=>$menus]);
    }
}
