<?php

namespace app\controllers;

use app\common\Controller;
use app\common\SystemEvent;

class DashboardController extends Controller
{
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
