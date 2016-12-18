<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View              $this
 * @var yii2mod\rbac\models\Route $model
 * @var ActiveForm                $form
 */

$this->title = '添加路由';
$this->params['breadcrumbs'][] = [
    'label' => 'Routes',
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header with-border">
    	<h3 class="box-title"><i class="fa fa-user"></i><span class="break"><?php echo Html::encode($this->title); ?></span></h3>
    	<div class="box-icon">
		</div>
    </div>
    <div class="box-body pad table-responsive">
<div class="create">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'route'); ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('user','Submit'), ['class' => 'btn btn-success']); ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- create -->
