<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var amnah\yii2\user\models\User $user
 * @var amnah\yii2\user\models\Profile $profile
 */

$this->title = Yii::t('user', 'Update User: ', [
  'modelClass' => 'User',
]) . ' ' . $user->id ;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->id, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = Yii::t('user', 'Update');
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-user"></i><span class="break"><?php echo Html::encode($this->title); ?></span><?=($user->id == $this->context->superadmin_uid ? " <button class=\"btn btn-success btn-xs\">超级管理员</button>" : "")?></h3>
    </div>
    <div class="box-body pad table-responsive">

    <?= $this->render('_form', [
        'user' => $user,
        'profile' => $profile,
    ]) ?>
</div>
</div>
