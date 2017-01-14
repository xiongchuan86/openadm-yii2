<?php


use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>
use yii\helpers\Json;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    <?= "<?php " ?>$form = ActiveForm::begin(); ?>

<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        //时间选择
        if(strpos($attribute,"_at") !== false){
            echo "<?php \$time = date(\"Y-m-d H:i:s\",\$model->isNewRecord ? time() : \$model->{$attribute});
                echo \$form->field(\$model, '{$attribute}')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => '','value'=>\$time],
            'pluginOptions' => [
                'autoclose' => true,
                'todayHighlight' => true,
                'format' => 'yyyy-mm-dd HH:ii:ss',
            ]
        ]); ?>\n\n";
        }else if($attribute == "thumb"){
            echo '<?= $form->field($model, \'thumb\')->hiddenInput([\'id\'=>\'thumb\'])?>
        <div class="form-group">
        <?php
        if($model->thumb>0){
            $uploadModel = \app\plugins\uploads\models\Uploads::findOne($model->thumb);
            $array = \'[{
                "id":\'.$uploadModel->id.\',
                "base_url": "\'.($uploadModel->bucket == "unkown" ? Yii::$app->fileStorage->baseUrl : $uploadModel->bucket) .\'",
                "path"    : "\'.$uploadModel->path.\'"}]\';
        }else{
            $array = \'[]\';
        }

        echo \app\plugins\uploads\widgets\Upload::widget([
            \'files\'=> new JsExpression($array),
            \'multiple\' => true,
            \'sortable\' => true,
            \'maxFileSize\' => 10 * 1024 * 1024, // 10Mb
            \'minFileSize\' => 1 * 1024 , // 1Kb
            \'maxNumberOfFiles\' => 1 ,
            \'acceptFileTypes\' => new JsExpression(\'/(\.|\/)(gif|jpe?g|png)$/i\'),
            \'clientOptions\' => [
                \'done\' => new JsExpression(\'function(e, data) { if(typeof data == "object" && typeof data.result == "object" && data.result.files.length>0)$("#thumb").val(data.result.files[0].id) }\'),
            ]
        ]);?>
        </div>'."\n\n";
        }else if(strpos($attribute,"is_") !== false){
            $method = "get".ucfirst($attribute)."DropdownList";

            echo '<?php
                $data = $model::'.$method.'();
                echo $form->field($model, \''.$attribute.'\')->widget(kartik\widgets\Select2::classname(), [
                    \'id\' => "'.$attribute.'",
                    \'hideSearch\' => true,
                    \'theme\' => Select2::THEME_DEFAULT,
                    \'size\' => Select2::MEDIUM,
                    \'data\' => $data,
                    \'options\' => [\'multiple\' => false],
                ]);?>'."\n\n";
        }
        else{
            echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
        }

    }
} ?>
        <div class="form-group">
        <?= "<?= " ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('添加') ?> : <?= $generator->generateString('更新') ?>, ['class' => 'btn btn-primary btn-sm']) ?>
        <?= "<?= " ?>Html::a('返回','index', ['class' => 'btn btn-default btn-sm']) ?>
    </div>
    <br />
    <?= "<?php " ?>ActiveForm::end(); ?>
</div>
