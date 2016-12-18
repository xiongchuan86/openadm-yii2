<?php

namespace app\common\components;

use Yii;
use yii\web\Controller;
use app\modules\rbac\components\AccessControl;
use yii\base\UserException;

class BaseController extends Controller
{
	public $layout = '/main';
	
	public function init(){
		parent::init();
	}
	
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
			        throw new UserException('You are not allowed to access this page');
			    }
            ],
        ];
    }
	
}