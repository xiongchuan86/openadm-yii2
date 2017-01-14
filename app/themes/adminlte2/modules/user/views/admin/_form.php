<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var amnah\yii2\user\Module $module
 * @var amnah\yii2\user\models\User $user
 * @var amnah\yii2\user\models\Profile $profile
 * @var amnah\yii2\user\models\Role $role
 * @var yii\widgets\ActiveForm $form
 */

$module = $this->context->module;
$role = $module->model("Role");
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
    ]); ?>

    <?= $form->field($user, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($user, 'username')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($user, 'newPassword')->passwordInput() ?>

    <?= $form->field($profile, 'full_name'); ?>

    <?php if(!$user->id == $this->context->superadmin_uid):?>
    <?php
        $role_id = Yii::$app->request->get('role_id','');
        if(!empty($role_id)){
            echo  $form->field($user, 'role_id',['labelOptions'=>['style'=>'display:none']])->hiddenInput(['value'=>$role_id]);
        }else{
            echo  $form->field($user, 'role_id')->dropDownList($role::dropdown(),['value'=>1]);
        }
    ?>

    <?= $form->field($user, 'status')->dropDownList($user::statusDropdown()); ?>


    <?php // use checkbox for banned_at ?>
    <?php // convert `banned_at` to int so that the checkbox gets set properly ?>
    <?php $user->banned_at = $user->banned_at ? 1 : 0 ?>
    <?= Html::activeLabel($user, 'banned_at', ['label' => Yii::t('user', 'Banned')]); ?>
    <?= Html::activeCheckbox($user, 'banned_at',['label'=>'']); ?>
    <?= Html::error($user, 'banned_at'); ?>

    <?= $form->field($user, 'banned_reason'); ?>
    <?php endif;?>

    <div class="form-group">
        <?= Html::submitButton($user->isNewRecord ? Yii::t('user', 'Create') : Yii::t('user', 'Update'), ['class' => $user->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('user', 'Cancel'),['index'], ['class' => 'btn btn-default']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
