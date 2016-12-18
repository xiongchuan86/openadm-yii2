<?php

namespace app\modules\user\controllers;

use Yii;
use app\modules\user\models\User;
use app\modules\user\models\UserKey;
use app\modules\user\models\UserAuth;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\common\Controller;
use app\common\SystemEvent;
/**
 * AdminController implements the CRUD actions for User model.
 */
class AdminController extends Controller
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
		
    }

  

    /**
     * List all User models
     *
     * @return mixed
     */
    public function actionIndex()
    {
    	SystemEvent::GetAdminMenu();
        /** @var \app\modules\user\models\search\UserSearch $searchModel */
        $searchModel = Yii::$app->getModule("user")->model("UserSearch");
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Display a single User model
     *
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
    	SystemEvent::GetAdminMenu();
        return $this->render('view', [
            'user' => $this->findModel($id),
        ]);
    }

    /**
     * Create a new User model. If creation is successful, the browser will
     * be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
    	SystemEvent::GetAdminMenu();
        /** @var \app\modules\user\models\User $user */
        /** @var \app\modules\user\models\Profile $profile */

        $user = Yii::$app->getModule("user")->model("User");
        $user->setScenario("admin");
        $profile = Yii::$app->getModule("user")->model("Profile");

        $post = Yii::$app->request->post();
        if ($user->load($post) && $user->validate() && $profile->load($post) && $profile->validate()) {
            $user->save(false);
            $profile->setUser($user->id)->save(false);
			//更新授权
			Yii::$app->authManager->assign(Yii::$app->authManager->getRole($user->role), $user->id);
            return $this->redirect(['view', 'id' => $user->id]);
        }

        // render
        return $this->render('create', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    /**
     * Update an existing User model. If update is successful, the browser
     * will be redirected to the 'view' page.
     *
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    	SystemEvent::GetAdminMenu();
        // set up user and profile
        $user = $this->findModel($id);
        $user->setScenario("admin");
        $profile = $user->profile;
		
		$old_role = $user->role;
        // load post data and validate
        $post = Yii::$app->request->post();
        if ($user->load($post) && $user->validate() && $profile->load($post) && $profile->validate()) {
            $user->save(false);
            $profile->setUser($user->id)->save(false);
			//删除授权
			Yii::$app->authManager->revoke(Yii::$app->authManager->getRole($old_role), $user->id);
			//更新授权
			Yii::$app->authManager->assign(Yii::$app->authManager->getRole($user->role), $user->id);
            return $this->redirect(['view', 'id' => $user->id]);
        }

        // render
        return $this->render('update', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    /**
     * Delete an existing User model. If deletion is successful, the browser
     * will be redirected to the 'index' page.
     *
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        // delete profile and userkeys first to handle foreign key constraint
        $user = $this->findModel($id);
        $profile = $user->profile;
        UserKey::deleteAll(['user_id' => $user->id]);
        UserAuth::deleteAll(['user_id' => $user->id]);
        $profile->delete();
        $user->delete();
		//删除授权
		Yii::$app->authManager->revoke(Yii::$app->authManager->getRole($user->role), $user->id);
        return $this->redirect(['index']);
    }

    /**
     * Find the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        /** @var \app\modules\user\models\User $user */
        $user = Yii::$app->getModule("user")->model("User");
        if (($user = $user::findOne($id)) !== null) {
            return $user;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
