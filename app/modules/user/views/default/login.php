<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var app\models\LoginForm $model
 */
?>
<div class="row">
		<div id="content" class="col-sm-12 full">
			<div class="row">
				<div class="login-box">
					<div class="header">
						<?= Html::encode(Yii::$app->name) ?>
					</div>
					<?php $form = ActiveForm::begin([
						'id' => 'login-form',
						'options' => ['class' => 'form-horizontal'],
					]); ?>
						<fieldset class="col-sm-12">
							<?= $form->field($model, 'username',[
								'template' => "
							  <div class=\"controls row\">
						      <div class=\"input-group col-sm-12\">{input}<span class=\"input-group-addon\"><i class=\"fa fa-user\"></i></span>
							  </div></div>\n<div class=\"col-lg-12\">{error}</div>",
							])->textInput(['placeholder'=>'输入Email或用户名']) ?>
							<?= $form->field($model, 'password',[
								'template' => "
							  <div class=\"controls row\">
						      <div class=\"input-group col-sm-12\">{input}<span class=\"input-group-addon\"><i class=\"fa fa-key\"></i></span>
							  </div></div>\n<div class=\"col-lg-12\">{error}</div>",
							])->passwordInput(['placeholder'=>'输入密码']) ?>
							<div class="confirm" style="  margin: 20px 0 10px -48px;">
								<?= $form->field($model, 'rememberMe', [
									'template' => "{input}",
								])->checkbox() ?>
							</div>
							<div class="row">
								<?= Html::submitButton(Yii::t('user', 'Login'), ['class' => 'btn btn-lg btn-primary col-xs-12']) ?>
							</div>
						</fieldset>	
					<?php ActiveForm::end(); ?>
					<a class="pull-left" href="<?=Url::to(["/user/forgot"])?>">忘记密码?</a>
					<?php if(0):?><a class="pull-right" href="<?=Url::to(["/user/register"])?>">注册!</a>
					<a class="pull-right" href="<?=Url::to(["/user/resend"])?>">重发注册邮件!</a>
					<?php endif;?>
					<div class="clearfix"></div>				
				</div>
			</div><!--/row-->
		
		</div>				
</div><!--/row-->	