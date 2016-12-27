<?php

namespace app\common\components;

use Yii;
use yii\web\Controller;
use app\modules\rbac\components\AccessControl;
use yii\base\UserException;
use yii\base\UnknownPropertyException;
class BaseController extends Controller
{
    public $layout = '/main';

    public function init(){
        parent::init();
    }

    public function getUniqueId()
    {
        if('plugin' == $this->module->getUniqueId()){
            //如果是plugin开头的plugin
            $pluginId = '';
            try{
                $pluginId = $this->module->pluginid;
            }catch (UnknownPropertyException $e){
                $array = explode("/",Yii::$app->requestedRoute);
                $pluginId = count($array)>1 ? $array[1] : '';
            }
            if($pluginId)
                return $this->module instanceof Application ? $this->id : $this->module->getUniqueId() . '/' . $pluginId . '/' . $this->id;
        }
        return $this->module instanceof Application ? $this->id : $this->module->getUniqueId() . '/' . $this->id;
    }

//	public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'denyCallback' => function ($rule, $action) {
//			        throw new UserException('You are not allowed to access this page');
//			    }
//            ],
//        ];
//    }

}