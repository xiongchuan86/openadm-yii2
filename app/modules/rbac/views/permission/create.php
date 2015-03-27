<?php

use yii\helpers\Html;

/**
 * @var yii\web\View                 $this
 * @var yii2mod\rbac\models\AuthItem $model
 */

$this->title = \Yii::t('user','Create Permission');
$this->params['breadcrumbs'][] = [
    'label' => \Yii::t('user','Permissions'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header">
    	<h2><i class="fa fa-user"></i><span class="break">添加权限</span></h2>
    	<div class="box-icon">
		</div>
    </div>
    <div class="box-content">
    <blockquote><p>A permission can be assigned to many operations.</p></blockquote>
    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>
</div>
</div>
