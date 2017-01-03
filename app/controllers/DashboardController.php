<?php

namespace app\controllers;

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
        return $this->renderPartial('index');
    }
	

}
