<?php
/**
 * 此文件作为示例存在,完全可以由plugin下面的home插件代替,具体参见frontend插件
 */
namespace app\controllers;

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

    public $layout = 'column1';

    public function actionIndex()
    {

        return $this->render('index');
    }
}
