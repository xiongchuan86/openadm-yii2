<?php

namespace app\modules\rbac\controllers;

use Yii;
use yii\filters\VerbFilter;
use app\common\Controller;
use yii\web\NotFoundHttpException;
use app\modules\rbac\models\BizRuleModel;
use app\modules\rbac\models\search\BizRuleSearch;
use app\modules\rbac\components\RbacBaseController;
/**
 * Class RuleController
 * @package yii2mod\rbac\controllers
 */
class RuleController extends RbacBaseController
{

    /**
     * Lists all rules
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BizRuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', ['model' => $model]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BizRuleModel(null);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Rule has been saved.');
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('create', ['model' => $model,]);
        }
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Rule has been saved.');
            return $this->redirect(['view', 'id' => $model->name]);
        }
        return $this->render('update', ['model' => $model,]);
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        Yii::$app->authManager->remove($model->item);
        Yii::$app->session->setFlash('success', 'Rule has been deleted.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $id
     *
     * @throws \yii\web\NotFoundHttpException
     * @return AuthItem the loaded model
     */
    protected function findModel($id)
    {
        $item = Yii::$app->authManager->getRule($id);
        if ($item) {
            return new BizRuleModel($item);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}