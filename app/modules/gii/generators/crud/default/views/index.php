<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
<?= $generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $generator->enablePjax ? "    <?php Pjax::begin(['options'=>['class'=>'nav-tabs-custom']]); ?>\n" : '<div class="nav-tabs-custom">' ?>
<?php if(!empty($generator->searchModelClass)): ?>
<?= "    <?php " . ($generator->indexWidgetType === 'grid' ? "// " : "") ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>

    <?= "<?php " ?> $content = '<p>'?>
    <?= "<?php " ?> $content.= ' '.Html::a('删除', "javascript:void(0);", ['class' => 'btn btn-sm btn-danger batchdelete']) ?>
    <?= "<?php " ?> $content.= '</p>'?>
<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?php \$content.=" ?>GridView::widget([
        'dataProvider' => $dataProvider,
        'layout'=>'{items}{summary}{pager}',
        'options'=>['id'=>'grid'],
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
            //['class' => 'yii\grid\SerialColumn'],

<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if($name == 'id'){
            echo '            [
                    \'class\' => \'yii\grid\CheckboxColumn\',//复选框
                    \'multiple\' => true,
                    \'name\' => \'id\'
                ],'."\n";
        }
        if($name=="create_at" || $name=="created_at"){
            echo '            [
                \'label\'=>\'添加日期\',
                \'attribute\'=>\'create_at\',
                \'format\' => [\'date\', \'php:Y-m-d H:i\'],
                \'value\' => \'create_at\'
            ],'."\n";
        }
        if (++$count < 6) {
            echo "            '" . $name . "',\n";
        } else {
            echo "            // '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        if($column->name == 'id'){
            echo '            [
                    \'class\' => \'yii\grid\CheckboxColumn\',//复选框
                    \'multiple\' => true,
                    \'name\' => \'id\'
                ],'."\n";
        }
        $format = $generator->generateColumnFormat($column);
        if($column->name=="create_at" || $column->name=="created_at"){
            echo '            [
                \'label\'=>\'添加日期\',
                \'attribute\'=>\'create_at\',
                \'format\' => [\'date\', \'php:Y-m-d H:i\'],
                \'value\' => \'create_at\'
            ],'."\n";
        }
        if (++$count < 6) {
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>

            ['class' => 'app\common\grid\ActionColumn'],
        ],
    ]); ?>
<?php else: ?>
    <?= "<?php \$content.= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ]) ?>
<?php endif; ?>

    <?= "<?= " ?> Tabs::widget([
        'items' => [
            [
                'label' =>  $this->title."管理",
                'content'=> $content,
                'active' => true
            ],
            [
                'label' => <?=$generator->generateString('添加' . Inflector::camel2words(StringHelper::basename($generator->modelClass)))?>,
                'url'=>['create'],
            ]
        ],
    ]);
    ?>
<?= $generator->enablePjax ? "    <?php Pjax::end(); ?>\n" : '</div>' ?>

<?= "<?php " ?>
$this->registerJs('
function oa_action(action,status,tips){
    var keys = $("#grid").yiiGridView("getSelectedRows");
    if(keys.length==0){
        noty({text: "请至少选择一条数据!",type:\'warning\'});
        return ;
    }
    if(tips == ""){
        $.ajax({
                url: action,
                type: \'post\',
                data: {ids:keys,status:status,_csrf:"'.Yii::$app->request->csrfToken.'"},
                success: function (data) {
                    // do something
                    if(data["code"] == 200){
                        noty({text: data.msg,type:\'success\'});
                        setTimeout(function(){location.href=oa_timestamp(location.href);},1000);
                    }else{
                        noty({text: data.msg,type:\'error\',timeout:1000});
                    }
                }
            });
    }else{
        yii.confirm(tips,function(){
            $.ajax({
                url: action,
                type: \'post\',
                data: {ids:keys,status:status,_csrf:"'.Yii::$app->request->csrfToken.'"},
                success: function (data) {
                    // do something
                    if(data["code"] == 200){
                        noty({text: data.msg,type:\'success\'});
                        setTimeout(function(){location.href=oa_timestamp(location.href);},1000);
                    }else{
                        noty({text: data.msg,type:\'error\',timeout:1000});
                    }
                }
            });
        });
    }
}
$(".batchdelete").on("click", function () {
    oa_action("deletes",1,"确定要删除?");
});
');
?>
