<?php

namespace app\controllers;

use Yii;
use app\common\Controller;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->redirect('/user/login/');
    }
	
	public function actionError()
	{
	    $exception = Yii::$app->errorHandler->exception;
	    if ($exception !== null) {
	        return $this->render('error', ['exception' => $exception]);
	    }
	}
	
	public function actionClear()
	{
		$asset = Yii::getAlias("@webroot")."/static/assets/*";
		//var_dump($asset);
		exec("rm -rf $asset");
	}

}
