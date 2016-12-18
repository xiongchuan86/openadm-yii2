<?php

use yii\helpers\Html;

/**
 * @var yii\web\View                 $this
 * @var yii2mod\rbac\models\AuthItem $model
 */
$this->title = \Yii::t('user','Update Role').': ' . $model->name;
$this->params['breadcrumbs'][] = [
    'label' => \Yii::t('user','Roles'),
    'url' => ['index']
];

$this->params['breadcrumbs'][] = \Yii::t('user','Update');
?>
<div class="box box-primary">
    <div class="box-header with-border">
    	<h3 class="box-title"><i class="fa fa-user"></i><span class="break"><?php echo Html::encode($this->title); ?></span></h3>
    	<div class="box-icon">
		</div>
    </div>
    <div class="box-body pad table-responsive">
    <?php echo $this->render('_form', [
        'model' => $model,
    ]);
    ?>
</div>
</div>