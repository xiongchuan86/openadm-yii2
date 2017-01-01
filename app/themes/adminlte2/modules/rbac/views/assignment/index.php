<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this \yii\web\View */
/* @var $gridViewColumns array */
/* @var $dataProvider \yii\data\ArrayDataProvider */
/* @var $searchModel \yii2mod\rbac\models\search\AssignmentSearch */

$this->title = Yii::t('yii2mod.rbac', 'Assignments');
$this->params['breadcrumbs'][] = $this->title;
$this->render('/layouts/_sidebar');
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-user"></i><span class="break"><?php echo Html::encode($this->title); ?></span></h3>
        <div class="box-icon">
        </div>
    </div>
    <div class="box-body pad table-responsive">

    <?php Pjax::begin(['timeout' => 5000]); ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{items}{summary}{pager}",
        'columns' => ArrayHelper::merge($gridViewColumns, [
            [
                'class' => 'app\common\grid\ActionColumn',
                'template' => '{view}',
            ],
        ]),
    ]); ?>

    <?php Pjax::end(); ?>
</div>
</div>
