<?php

namespace app\controllers;

use app\common\Controller;
use app\modules\rbac\components\AccessControl;

class DashboardController extends Controller
{
	public $layout = "column2";
	
    public function actionMain()
    {
        return $this->render('main');
    }
	

}
