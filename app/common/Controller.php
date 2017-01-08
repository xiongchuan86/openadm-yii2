<?php

namespace app\common;

use yii\web\Controller as BaseController;


class Controller extends BaseController
{
    public $layout = '/main';//必须是/main,斜线不能去掉,否则Plugin找不到模板

    public function init(){
        parent::init();
    }

}