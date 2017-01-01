<?php

use yii\helpers\Html;
use yii\helpers\Json;

use yii2mod\rbac\RbacRouteAsset;
RbacRouteAsset::register($this);
/* @var $this yii\web\View */
/* @var $routes [] */

$this->title = Yii::t('yii2mod.rbac', 'Routes');
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
<?php echo Html::a(Yii::t('yii2mod.rbac', 'Refresh'), ['refresh'], [
    'class' => 'btn btn-primary btn-sm',
    'id' => 'btn-refresh',
]); ?>
<?php echo $this->render('../_dualListBox', [
    'opts' => Json::htmlEncode([
        'items' => $routes,
    ]),
    'assignUrl' => ['assign'],
    'removeUrl' => ['remove'],
]); ?>
</div>
</div>
