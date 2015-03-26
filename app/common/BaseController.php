<?php

namespace app\common;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\common\SystemConfig;

class BaseController extends Controller
{
	public function init(){
		parent::init();
		$this->GetSystemConfig();
	}
	
	//获取系统配置
	public function GetSystemConfig(){
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