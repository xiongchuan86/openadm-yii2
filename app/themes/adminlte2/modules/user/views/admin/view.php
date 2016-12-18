<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var amnah\yii2\user\models\User $user
 */

$this->title = Yii::t('user', 'User').":".$user->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-user"></i><span class="break"><?php echo Html::encode($this->title); ?></span></h3>
        <div class="box-icon">
        </div>
    </div>
    <div class="box-body pad table-responsive">

    <p>
        <?= Html::a(Yii::t('user', 'Update'), ['update', 'id' => $user->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('user', 'Delete'), ['delete', 'id' => $user->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('user', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?php echo Html::a(Yii::t('user', '返回'),['index'], ['class' => 'btn btn-default']); ?>
    </p>

    <?= DetailView::widget([
        'model' => $user,
        'attributes' => [
            'id',
            'role_id',
            'status',
            'email:email',
            'username',
            'profile.full_name',
            'password',
            'auth_key',
            'access_token',
            'logged_in_ip',
            'logged_in_at',
            'created_ip',
            'created_at',
            'updated_at',
            'banned_at',
            'banned_reason',
        ],
    ]) ?>
</div>
</div>
