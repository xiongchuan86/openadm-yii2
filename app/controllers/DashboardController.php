<?php

namespace app\controllers;

use app\common\Controller;

class DashboardController extends Controller
{
	public $layout = "column2";
	
    public function actionMain()
    {
        return $this->render('main');
    }

}
