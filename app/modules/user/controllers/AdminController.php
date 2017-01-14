<?php

namespace app\modules\user\controllers;

use Yii;
use amnah\yii2\user\models\User;
use amnah\yii2\user\models\UserToken;
use amnah\yii2\user\models\UserAuth;
use app\common\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii2mod\editable\EditableAction;
use yii2mod\rbac\filters\AccessControl;

/**
 * AdminController implements the CRUD actions for User model.
 */
class AdminController extends Controller
{
    /**
     * @var \amnah\yii2\user\Module
     * @inheritdoc
     */
    public $module;

    public $protected_uids = [];

    public $superadmin_uid = 0;

    public $loginRedirect = '/admin/dashboard';

    public function init()
    {
        parent::init();
        $this->protected_uids[] = $this->superadmin_uid;//把superadmin 默认加入受保护的列表
        $this->attachBehaviors([
            'access' => [
                'class' => AccessControl::className(),
                'allowActions'=>[
                    'login',
                    'logout',
                ],
                'denyCallback' => function ($rule, $action) {
                    $this->redirect('/user/admin/login');
                }
            ],
        ]);
    }

    /**
     * Display login page
     */
    public function actionLogin()
    {
        $this->layout = '/public';

        /** @var \amnah\yii2\user\models\forms\LoginForm $model */
        $model = $this->module->model("LoginForm");

        // load post data and login
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            $returnUrl = $this->performLogin($model->getUser(), $model->rememberMe);
            return $this->redirect($returnUrl);
        }

        return $this->render('login', compact("model"));
    }

    /**
     * Perform the login
     */
    protected function performLogin($user, $rememberMe = true)
    {
        // log user in
        $loginDuration = $rememberMe ? $this->module->loginDuration : 0;
        Yii::$app->user->login($user, $loginDuration);

        return $this->loginRedirect;
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        // handle redirect
        $logoutRedirect = $this->module->logoutRedirect;
        if ($logoutRedirect) {
            return $this->redirect($logoutRedirect);
        }
        return $this->goHome();
    }

    /**
     * Account
     */
    public function actionAccount()
    {
        /** @var \amnah\yii2\user\models\User $user */
        /** @var \amnah\yii2\user\models\UserToken $userToken */

        // set up user and load post data
        $user = Yii::$app->user->identity;
        $user->setScenario("account");
        $loadedPost = $user->load(Yii::$app->request->post());

        // validate for ajax request
        if ($loadedPost && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($user);
        }

        // validate for normal request
        $userToken = $this->module->model("UserToken");
        if ($loadedPost && $user->validate()) {

            // check if user changed his email
            $newEmail = $user->checkEmailChange();
            if ($newEmail) {
                $userToken = $userToken::generate($user->id, $userToken::TYPE_EMAIL_CHANGE, $newEmail);
                if (!$numSent = $user->sendEmailConfirmation($userToken)) {

                    // handle email error
                    //Yii::$app->session->setFlash("Email-error", "Failed to send email");
                }
            }

            // save, set flash, and refresh page
            $user->save(false);
            Yii::$app->session->setFlash("success", Yii::t("user", "Account updated"));
            return $this->refresh();
        } else {
            $userToken = $userToken::findByUser($user->id, $userToken::TYPE_EMAIL_CHANGE);
        }

        return $this->render("account", compact("user", "userToken"));
    }

    /**
     * Profile
     */
    public function actionProfile()
    {
        /** @var \amnah\yii2\user\models\Profile $profile */

        // set up profile and load post data
        $profile = Yii::$app->user->identity->profile;
        $loadedPost = $profile->load(Yii::$app->request->post());

        // validate for ajax request
        if ($loadedPost && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($profile);
        }

        // validate for normal request
        if ($loadedPost && $profile->validate()) {
            $profile->save(false);
            Yii::$app->session->setFlash("success", Yii::t("user", "Profile updated"));
            return $this->refresh();
        }

        return $this->render("profile", compact("profile"));
    }

    /**
     * List all User models
     * @return mixed
     */
    public function actionIndex()
    {
        /** @var \amnah\yii2\user\models\search\UserSearch $searchModel */
        $searchModel = $this->module->model("UserSearch");
        $params = Yii::$app->request->getQueryParams();
        $dataProvider = $searchModel->search($params);

        return $this->render('index', compact('searchModel', 'dataProvider'));
    }

    /**
     * Display a single User model
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'user' => $this->findModel($id),
        ]);
    }

    /**
     * Create a new User model. If creation is successful, the browser will
     * be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /** @var \amnah\yii2\user\models\User $user */
        /** @var \amnah\yii2\user\models\Profile $profile */

        $user = $this->module->model("User");
        $user->setScenario("admin");
        $profile = $this->module->model("Profile");

        $post = Yii::$app->request->post();
        $userLoaded = $user->load($post);
        $profile->load($post);

        // validate for ajax request
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            //return ActiveForm::validate($user, $profile);
        }

        if ($userLoaded && $user->validate() && $profile->validate()) {
            $user->save(false);
            $profile->setUser($user->id)->save(false);
            //更新授权
            Yii::$app->authManager->assign(Yii::$app->authManager->getRole($user->role->name), $user->id);
            return $this->redirect(['index']);
        }

        // render
        return $this->render('create', compact('user', 'profile'));
    }

    /**
     * Update an existing User model. If update is successful, the browser
     * will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        // set up user and profile
        $user = $this->findModel($id);
        $user->setScenario("admin");
        $profile = $user->profile;

        $post = Yii::$app->request->post();
        $userLoaded = $user->load($post);
        $profile->load($post);

        // validate for ajax request
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($user, $profile);
        }
        $old_role = $user->role;
        // load post data and validate
        if ($userLoaded && $user->validate() && $profile->validate()) {
            $user->save(false);
            $profile->setUser($user->id)->save(false);
            //删除授权
            Yii::$app->authManager->revoke(Yii::$app->authManager->getRole($old_role->name), $user->id);
            //更新授权
            Yii::$app->authManager->assign(Yii::$app->authManager->getRole($user->role->name), $user->id);
            return $this->redirect(['index']);
        }

        // render
        return $this->render('update', compact('user', 'profile'));
    }

    /**
     * Delete an existing User model. If deletion is successful, the browser
     * will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(in_array($id,$this->protected_uids)){
            Yii::$app->session->setFlash("warning","受保护的账号,不允许删除!");
            return $this->redirect(['index']);
        }
        // delete profile and userTokens first to handle foreign key constraint
        $user = $this->findModel($id);
        $profile = $user->profile;
        UserToken::deleteAll(['user_id' => $user->id]);
        UserAuth::deleteAll(['user_id' => $user->id]);
        $profile->delete();
        $user->delete();
        //删除授权
        Yii::$app->authManager->revoke(Yii::$app->authManager->getRole($user->role->name), $user->id);
        Yii::$app->session->setFlash("success","删除完成");
        return $this->redirect(['index']);
    }

    private function deleteUid($id)
    {
        if(in_array($id,$this->protected_uids)){
            return false;
        }
        $user = $this->findModel($id);
        if($user){
            $profile = $user->profile;
            UserToken::deleteAll(['user_id' => $user->id]);
            UserAuth::deleteAll(['user_id' => $user->id]);
            $profile->delete();
            $user->delete();
            //删除授权
            Yii::$app->authManager->revoke(Yii::$app->authManager->getRole($user->role->name), $user->id);
            return true;
        }
        return false;
    }

    public function actionDeletes()
    {
        $result= ['code'=>200];
        $data = [];
        $post = Yii::$app->request->post();
        if($post && isset($post['ids']) && is_array($post['ids'])){
            $protected_uids_num = 0;
            foreach ($post['ids'] as $id){
                if(in_array($id,$this->protected_uids)){
                    $protected_uids_num++;
                }else{
                    if($this->deleteUid($id)){
                        $data[] = $id;
                    }
                }
            }
            $result['data'] = $data;
            $result['msg']  = '删除完成!';
            if($protected_uids_num>0 && count($post['ids'])==$protected_uids_num){
                $result=['code'=>0,'msg'=>'受保护的账号,不允许删除!'];
            }else if($protected_uids_num>0 && $protected_uids_num<count($post['ids'])){
                $result=['code'=>200,'msg'=>'删除完成,其中受保护的账号,不允许删除!'];
            }

        }else{
            $result=['code'=>0,'msg'=>'请选择要删除的用户!'];
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $result;
        }
        return $this->redirect(['index']);
    }

    public function actionActive()
    {
        $result= ['code'=>200];
        $data = [];
        $post = Yii::$app->request->post();
        $status = Yii::$app->request->post('status',0);
        if($post && isset($post['ids']) && is_array($post['ids'])){
            $protected_uids_num = 0;
            foreach ($post['ids'] as $id){
                if(in_array($id,$this->protected_uids)){
                    $protected_uids_num++;
                }else{
                    $user = $this->findModel($id);
                    $user->status = $status;
                    $user->save();
                    $data[] = $id;
                }
            }
            $result['data'] = $data;
            $result['msg']  = '操作完成!';
            if($protected_uids_num>0 && count($post['ids'])==$protected_uids_num){
                $result=['code'=>0,'msg'=>'受保护的账号,不允许改变激活状态!'];
            }else if($protected_uids_num>0 && $protected_uids_num<count($post['ids'])){
                $result=['code'=>200,'msg'=>'操作完成,其中受保护的账号,不允许改变激活状态!'];
            }

        }else{
            $result=['code'=>0,'msg'=>'请选择要操作的数据!'];
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $result;
        }
        return $this->redirect(['index']);
    }

    public function actionBanned()
    {
        $result= ['code'=>200];
        $data = [];
        $post = Yii::$app->request->post();
        $status = Yii::$app->request->post('status',0);
        if($post && isset($post['ids']) && is_array($post['ids'])){
            $protected_uids_num = 0;
            foreach ($post['ids'] as $id){
                if(in_array($id,$this->protected_uids)){
                    $protected_uids_num++;
                }else{
                    $user = $this->findModel($id);
                    if($status ==0){
                        $user->banned_at     = "";
                        $user->banned_reason = "";
                    }else{
                        $user->banned_at     = date("Y-m-d H:i:s");
                        $user->banned_reason = "管理员ID=".Yii::$app->user->id."操作";
                    }
                    $user->save();
                    $data[] = $id;
                }
            }
            $result['data'] = $data;
            $result['msg']  = '操作完成!';
            if($protected_uids_num>0 && count($post['ids'])==$protected_uids_num){
                $result=['code'=>0,'msg'=>'受保护的账号,不允许禁用!'];
            }else if($protected_uids_num>0 && $protected_uids_num<count($post['ids'])){
                $result=['code'=>200,'msg'=>'操作完成,其中受保护的账号,不允许禁用!'];
            }

        }else{
            $result=['code'=>0,'msg'=>'请选择要操作的数据!'];
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $result;
        }
        return $this->redirect(['index']);
    }

    /**
     * Find the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        /** @var \amnah\yii2\user\models\User $user */
        $user = $this->module->model("User");
        $user = $user::findOne($id);
        if ($user) {
            return $user;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actions()
    {
        return [
            'change-role' => [
                'class' => EditableAction::class,
                'modelClass' => User::class,
                'forceCreate' => false,
            ],
            'change-status' => [
                'class' => EditableAction::class,
                'modelClass' => User::class,
                'forceCreate' => false,
            ],
        ];
    }
}
