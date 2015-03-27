<?php

namespace app\common;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\common\SystemConfig;
use app\modules\rbac\components\AccessControl;
use yii\base\UserException;

class BaseController extends Controller
{
	public $layout = '/column2';
	
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