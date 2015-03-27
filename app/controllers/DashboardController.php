<?php

namespace app\controllers;

use app\common\Controller;
use app\common\SystemEvent;

class DashboardController extends Controller
{
	public $layout = "column2";
	
	public function init()
	{
		parent::init();
		
	}
	
    public function actionMain()
    {
    	SystemEvent::GetAdminMenu();
        return $this->render('main');
    }
	

}
