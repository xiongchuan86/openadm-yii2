<?php

namespace app\common;

use app\common\components\PluginBaseController;
use yii2mod\rbac\filters\AccessControl;
use yii\base\UserException;

class AdminPluginController extends PluginBaseController
{
    public $layout = '/main';//必须是/main,斜线不能去掉,否则Plugin找不到模板

    public function init(){
        parent::init();
        $this->attachBehaviors([
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    throw new UserException('你没权限进入此页面!');
                }
            ],
        ]);
    }

}