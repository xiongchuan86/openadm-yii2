<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/**
 * @var yii\web\View                       $this
 * @var yii\data\ActiveDataProvider        $dataProvider
 * @var yii2mod\rbac\models\AuthItemSearch $searchModel
 */
$this->title = '角色列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header">
    	<h2><i class="fa fa-user"></i><span class="break"><?php echo Html::encode($this->title); ?></span></h2>
    	<div class="box-icon">
		</div>
    </div>
    <div class="box-content">

    <p>
        <?php echo Html::a(\Yii::t('user','Create Role'), ['create'], ['class' => 'btn btn-success']); ?>
    </p>

    <?php Pjax::begin(['enablePushState' => false, 'timeout' => 5000]); ?>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
            	'attribute' => 'name',
            	'label'     => \Yii::t('user','Name'),
            ],
            [
            	'attribute' => 'description',
            	'format' => ['ntext'],
            	'label'     => \Yii::t('user','Description'),
            ],
            ['class' => 'yii\grid\ActionColumn',],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
</div>