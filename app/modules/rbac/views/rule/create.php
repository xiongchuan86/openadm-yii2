<?php

use yii\helpers\Html;

/**
 * @var yii\web\View                 $this
 * @var yii2mod\rbac\models\AuthItem $model
 */

$this->title = 'Create BizRule';
$this->params['breadcrumbs'][] = [
    'label' => 'BizRules',
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header">
    	<h2><i class="fa fa-user"></i><span class="break">添加规则</span></h2>
    	<div class="box-icon">
		</div>
    </div>
    <div class="box-content">
    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
</div>