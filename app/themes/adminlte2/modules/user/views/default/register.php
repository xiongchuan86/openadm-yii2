<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var app\modules\user\models\User $user
 * @var app\modules\user\models\User $profile
 * @var string $userDisplayName
 */
?>
<div class="row">
	<div id="content" class="col-sm-12 full">
		<div class="row">
			<div class="login-box">
				<div class="header">
					<?php echo Yii::$app->name;?>
				</div>
	<?php if ($flash = Yii::$app->session->getFlash("Register-success")): ?>
        <div class="alert alert-success">
            <p><?= $flash ?></p>
        </div>
    <?php else: ?>
        <p><?= Yii::t("user", "Please fill out the following fields to register:") ?></p>
        <?php $form = ActiveForm::begin([
            'id' => 'register-form',
            'options' => ['class' => 'form-horizontal'],
            'enableAjaxValidation' => true,
        ]); ?>
        <?php if (Yii::$app->getModule("user")->requireEmail): ?>
            <?= $form->field($user, 'email',[
            	'template'=>'{label}
						  	<div class="controls row">
								<div class="input-group col-sm-12">
									{input}
								</div>
								<div class=\"col-lg-12\">{error}</div>	
						  	</div>'
            ]) ?>
        <?php endif; ?>
        <?php if (Yii::$app->getModule("user")->requireUsername): ?>
            <?= $form->field($user, 'username',[
            	'template'=>'{label}
						  	<div class="controls row">
								<div class="input-group col-sm-12">
									{input}
								</div>
								<div class=\"col-lg-12\">{error}</div>	
						  	</div>'
            ]) ?>
        <?php endif; ?>

        <?= $form->field($user, 'newPassword',[
        	'template'=>'{label}
						  	<div class="controls row">
								<div class="input-group col-sm-12">
									{input}
								</div>
								<div class=\"col-lg-12\">{error}</div>	
						  	</div>'
        ])->passwordInput() ?>
        <div class="form-group">
                <?= Html::submitButton(Yii::t('user', 'Register'), ['class' => 'btn btn-primary btn-lg col-xs-12']) ?>
        </div>
        <?php ActiveForm::end(); ?>
			
    <?php endif; ?>
    <a class="pull-left" href="<?=Url::to(["/user/login"])?>">登录</a>
			</div>
		</div><!--/row-->
	</div>			
</div><!--/row-->	