<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var amnah\yii2\user\Module $module
 * @var amnah\yii2\user\models\User $user
 * @var amnah\yii2\user\models\User $profile
 * @var string $userDisplayName
 */

$module = $this->context->module;

$this->title = Yii::t('user', 'Register');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">
    <div class="login-logo">
        <a href="/">Open<b>Adm</b></a>
    </div>
    <div class="login-box-body">

        <p class="login-box-msg"><?=Yii::t('user','Register')?></p>

    <?php if ($flash = Yii::$app->session->getFlash("Register-success")): ?>

        <div class="alert alert-success">
            <p><?= $flash ?></p>
        </div>

    <?php else: ?>

        <?php $form = ActiveForm::begin([
            'id' => 'register-form',
            'enableAjaxValidation' => true,
        ]); ?>

        <?php if ($module->requireEmail): ?>
            <?= $form->field($user, 'email',['template'=>"<div class=\"form-group has-feedback\">{input}<span class=\"glyphicon glyphicon-envelope form-control-feedback\"></span><div class=\"\">{error}</div></div>"])->textInput(['placeholder'=>'Email']) ?>
        <?php endif; ?>

        <?php if ($module->requireUsername): ?>
            <?= $form->field($user, 'username',['template'=>"<div class=\"form-group has-feedback\">{input}<span class=\"glyphicon glyphicon-user form-control-feedback\"></span><div class=\"\">{error}</div></div>"])->textInput(['placeholder'=>'Email']) ?>
        <?php endif; ?>

        <?= $form->field($user, 'newPassword',['template'=>"<div class=\"form-group has-feedback\">{input}<span class=\"glyphicon glyphicon-lock form-control-feedback\"></span><div class=\"\">{error}</div></div>"])->passwordInput(['placeholder'=>'Password']) ?>

        <?php /* uncomment if you want to add profile fields here
        <?= $form->field($profile, 'full_name') ?>
        */ ?>

        <div class="form-group">
                <?= Html::submitButton(Yii::t('user', 'Register'), ['class' => 'btn btn-primary','style'=>'width:100%;']) ?>
        </div>
        <div class="form-group">
            <?= Html::a(Yii::t('user', 'Login'), ["/user/login"],['class'=>'']) ?>
        </div>
        </div>

        <?php ActiveForm::end(); ?>
    <?php endif; ?>

</div>
</div>