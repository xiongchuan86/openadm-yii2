<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Button;
$user = Yii::$app->getModule("user")->model("User");
$role = Yii::$app->getModule("user")->model("Role");

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\modules\user\models\search\UserSearch $searchModel
 * @var app\modules\user\models\User $user
 * @var app\modules\user\models\Role $role
 */

$this->title = Yii::t('user', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header">
    	<h2><i class="fa fa-user"></i><span class="break">用户列表</span></h2>
    	<div class="box-icon">
		</div>
    </div>
    <div class="box-content">
    <?= Html::a('添加', ['create'], ['class' => 'btn btn-success']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],
            [
            	'attribute' => 'id',
            	'options' => ['style'=>'width:5%']
            ],
            [
            	'attribute' => 'email',
            	'options' => ['style'=>'width:20%']
            ],
            [
            	'attribute' => 'profile.full_name',
            	'options' => ['style'=>'width:20%']
            ],
            [
                'attribute' => 'role_id',
                'label' => Yii::t('user', 'Role'),
                'filter' => $role::dropdown(),
                'value' => function($model, $index, $dataColumn) use ($role) {
                    $roleDropdown = $role::dropdown();
                    return $roleDropdown[$model->role_id];
                },
                'options' => ['style'=>'width:10%']
            ],
            [
                'attribute' => 'status',
                'label' => Yii::t('user', 'Status'),
                'filter' => $user::statusDropdown(),
                'value' => function($model, $index, $dataColumn) use ($user) {
                    $statusDropdown = $user::statusDropdown();
                    return $statusDropdown[$model->status];
                },
                'options' => ['style'=>'width:15%']
            ],
            
            [
            	'attribute' => 'create_time',
            	'options' => ['style'=>'width:20%']
            ],
            // 'new_email:email',
            // 'username',
            // 'password',
            // 'auth_key',
            // 'api_key',
            // 'login_ip',
            // 'login_time',
            // 'create_ip',
            // 'create_time',
            // 'update_time',
            // 'ban_time',
            // 'ban_reason',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
	</div>
</div>
