<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\common\EditableColumn;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var amnah\yii2\user\Module $module
 * @var amnah\yii2\user\models\search\UserSearch $searchModel
 * @var amnah\yii2\user\models\User $user
 * @var amnah\yii2\user\models\Role $role
 */

$module = $this->context->module;
$controller = $this->context;
$user = $module->model("User");
$role = $module->model("Role");
$this->title = Yii::t('user', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-user"></i><span class="break"><?php echo Html::encode($this->title); ?></span></h3>
        <div class="box-icon">
        </div>
    </div>
    <div class="box-body pad table-responsive">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('user', '添加用户'), ['create'], ['class' => 'btn btn-success btn-sm']) ?>
        <?= Html::a('批量删除', "javascript:void(0);", ['class' => 'btn btn-default btn-sm gridview']) ?>
    </p>
        <?php
        $this->registerJs('
$(".gridview").on("click", function () {
    var keys = $("#grid").yiiGridView("getSelectedRows");
    if(keys.length==0){
        alert("请选择用户!");
        return ;
    }
    $.ajax({
        url: "/user/admin/deletes",
        type: \'post\',
        data: {ids:keys,_csrf:"'.Yii::$app->request->csrfToken.'"},
        success: function (data) {
            // do something
            if(data["code"] == 200){
                noty({text: data.msg,type:\'success\'});
			    setTimeout(function(){location.reload();},1000);
            }else{
                noty({text: data.msg,type:\'error\',timeout:1000});
            }
        }
    });
});
');


        ?>
    <?php \yii\widgets\Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{items}{summary}{pager}",
        'options'=>['id'=>'grid'],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',//复选框
                'multiple' => true,
                'name' => 'uid'
            ],

            [
                'attribute' => 'id',
                'filterOptions'=>['style'=>'width:50px']
            ],
            [
                'attribute' => 'username',
                'value' => function($model)use($controller){
                    return $model->username.($model->id == $controller->superadmin_uid ? "(超级管理员)" :"");
                }
            ],
            [
                'class' => EditableColumn::className(),
                'url' => ['change-role'],
                'type' => 'select',
                'editableOptions' => function ($model) use($role,$controller){
                    if($model->id == $controller->superadmin_uid)return false;
                    return [
                        'source' => $role::dropdown(),
                        'value' => $model->role_id,
                    ];
                },
                'attribute' => 'role_id',
                'label' => Yii::t('user', 'Role'),
                'filter' => $role::dropdown(),
                'value' => function($model, $index, $dataColumn) use ($role) {
                    $roleDropdown = $role::dropdown();
                    return $roleDropdown[$model->role_id];
                },
            ],
            [
                'class' => EditableColumn::className(),
                'url' => ['change-status'],
                'type' => 'select',
                'editableOptions' => function ($model) use($user,$controller){
                    if($model->id == $controller->superadmin_uid)return false;
                    $source = $user::statusDropdown();
                    krsort($source);//如果不倒序排列,source序列化会变成数组而不是对象
                    return [
                        'source' => $source,
                        'value' => $model->status,
                    ];
                },
                'attribute' => 'status',
                'label' => Yii::t('user', 'Status'),
                'filter' => $user::statusDropdown(),
                'value' => function($model, $index, $dataColumn) use ($user) {
                    $statusDropdown = $user::statusDropdown();
                    return $statusDropdown[$model->status];
                },
                'filterOptions'=>['style'=>'width:100px']
            ],
            'email:email',
            //'profile.full_name',
            //'profile.timezone',
            'created_at',

            // 'password',
            // 'auth_key',
            // 'access_token',
            // 'logged_in_ip',
            // 'logged_in_at',
            // 'created_ip',
            // 'updated_at',
            // 'banned_at',
            // 'banned_reason',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
</div>
