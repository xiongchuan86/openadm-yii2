<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = '权限管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header">
    	<h2><i class="fa fa-user"></i><span class="break">用户列表</span></h2>
    	<div class="box-icon">
		</div>
    </div>
    <div class="box-content">
	
    <?php Pjax::begin(['enablePushState' => false, 'timeout' => 5000]); ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => $usernameField,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
</div>