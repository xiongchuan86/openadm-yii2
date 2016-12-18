<?php

use yii\helpers\Html;

/**
 * @var yii\web\View                 $this
 * @var yii2mod\rbac\models\AuthItem $model
 */

$this->title = 'Create Role';
$this->params['breadcrumbs'][] = [
    'label' => 'Roles',
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header with-border">
    	<h3 class="box-title"><i class="fa fa-user"></i><span class="break">创建角色</span></h3>
    	<div class="box-icon">
		</div>
    </div>
    <div class="box-body pad table-responsive">
    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
</div>