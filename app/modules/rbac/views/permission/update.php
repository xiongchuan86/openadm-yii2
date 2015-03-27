<?php

use yii\helpers\Html;

/**
 * @var yii\web\View                 $this
 * @var yii2mod\rbac\models\AuthItem $model
 */
$this->title = '更新权限: ' . $model->name;
$this->params['breadcrumbs'][] = [
    'label' => 'Permissions',
    'url' => ['index']
];
$this->params['breadcrumbs'][] = [
    'label' => $model->name,
    'url' => [
        'view',
        'id' => $model->name
    ]
];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="box">
    <div class="box-header">
    	<h2><i class="fa fa-user"></i><span class="break"><?php echo Html::encode($this->title); ?></span></h2>
    	<div class="box-icon">
		</div>
    </div>
    <div class="box-content">
    <?php echo $this->render('_form', [
        'model' => $model,
    ]);
    ?>
</div>
</div>