<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\bootstrap\Button;
use yii\bootstrap\Modal;
$this->params['breadcrumbs'][] = '插件管理';
?>
<style>
.table thead>tr>th, .table tbody>tr>th, .table tfoot>tr>th, .table thead>tr>td, .table tbody>tr>td, .table tfoot>tr>td{font-size:12px;line-height:20px;padding:3px;overflow:hidden;height:20px;}
td{padding:0;}
.pagination{margin:5px 0;}
</style>
<div class="nav-tabs-custom">
<?php
$items = [
    ['label'=>'全部','url'=>['local','tab'=>'all'],'active'=>'true'],
    ['label'=>'已安装','url'=>['local','tab'=>'setuped'],'active'=>'true'],
    ['label'=>'未安装','url'=>['local','tab'=>'new'],'active'=>'true'],
];
foreach (['all','setuped','new'] as $i=>$v){
    if($tab!=$v){
        unset($items[$i]['active']);
    }
}
echo Nav::widget(array(
    'options' => ['class' =>'nav-tabs'],
    'items'=>$items
));
?>
<div class="tab-content">
<?php
$data = array(); 
if(is_array($result) && isset($result['data'])){
	foreach($result['data'] as $v){
		if(is_array($v)){
			$author = isset($v['config']['author']) ? "开发者:".$v['config']['author'] :'';
			$email = isset($v['config']['email']) ? "联系方式:".$v['config']['email'] :'';
			$dependencies = isset($v['config']['dependencies']) ? $v['config']['dependencies'] :'';
			$v['config']['description'] = mb_substr($v['config']['description'], 0,"255");
			$v['config']['description'] .= "<br/>".$author.", ".$email;
			if(!empty($dependencies)){
				$v['config']['description'] .= "<br/>"."依赖插件:".$dependencies;
			}
			if(!empty($v['config']['needed'])){
				$v['config']['description'] .= "<br/>"."<font color='#f00' id='needed'>缺失依赖插件:</font>".$v['config']['needed'];
			}
			//增加操作类型
            $btn_setup_label = Html::tag('i','安装',['class'=>'fa fa-cog']);
			$btn_setup = Html::a($btn_setup_label,'#',['class' => 'setup btn btn-xs btn-primary','style'=>'','data-toggle' => 'modal']);

            $btn_unsetup_label = Html::tag('i','卸载',['class'=>'fa fa-edit']);
			$btn_unsetup = Html::a($btn_unsetup_label,'#',['class' => 'unsetup btn btn-xs btn-success','style'=>'','data-toggle' => 'modal']);

			$btn_delete_label = Html::tag('i','删除',['class'=>'fa fa-trash']);
            $btn_delete = Html::a($btn_delete_label,'#',['class' => 'delete btn btn-xs btn-danger','style'=>'','data-toggle' => 'modal']);
			$v['config']['_action_'] = '';
			if($v['setup']){
				$v['config']['_action_'] = $btn_unsetup;
			}else{
				$v['config']['_action_'] = $btn_setup.' '.$btn_delete;
			}
			$data[]=$v['config'];
		}
			
	}
}

$gridDataProvider = new ArrayDataProvider([
    'allModels' => $data,
    'sort' => [
        'attributes' => ['id', 'username', 'email'],
    ],
    'pagination' => [
        'pageSize' => 20,
    ],
]);
//,'onclick'=>'plugin_action(this,"setup")'
//$gridDataProvider->setTotalItemCount(isset($result['total']) ? $result['total'] :0);
//$gridDataProvider->getPagination()->pageSize = isset($result['pageSize']) ? $result['pageSize'] :0;
echo GridView::widget([
    'dataProvider' => $gridDataProvider,
    'layout' => "{items}{summary}{pager}",
    'columns' => array(
        array('attribute'=>'id', 'header'=>'ID','options'=>array('style'=>'width:15%','class'=>'pluginid')),
        array('attribute'=>'name', 'header'=>'名称','options'=>array('style'=>'width:15%')),
        array('attribute'=>'type', 'header'=>'类型','options'=>array('style'=>'width:5%')),
        array('attribute'=>'version', 'header'=>'版本','options'=>array('style'=>'width:5%')),
        array('attribute'=>'description', 'header'=>'描述','format' => 'raw','options'=>array('style'=>'width:45%')),
        array('attribute'=>'_action_','header'=>'操作','format' => 'raw','options'=>array('style'=>'width:15%')),
    ),
]);
?>
</div>

</div>
<script>
//setup a plugin
function plugin_action(o,action)
{
	if('delete'==action){
        yii.confirm("确定要删除吗？",function () {
            doAction(o,action);
        },function () {
            return;
        });
	}else if('unsetup'==action){
        yii.confirm("确定要卸载吗？",function () {
            doAction(o,action);
        },function () {
            return;
        });
	}else{
        doAction(o,action);
    }

}

function doAction(o,action){
    $('#install-modal').modal('show');
    $('.modal-body').css('height','400px');
    $('.modal-body').css('overflow-y','scroll');
    var tr = $(o).parent().parent();
    var id = tr.find("td:first").text();

    //使用iframe
    submitForm('/admin/plugin-manager/ajax',{pluginid:id,action:action,'_csrf':'<?=Yii::$app->request->csrfToken?>'});
}

window.onmessage = function (msg,boxId) {
    var box = [];
    if(boxId != ''){
        box = $('#'+boxId);
    }
    if(box.length>0){
        box.append(msg);
    }else{
        $('.modal-body').append(msg);
    }
}

function submitForm(url,data)
{
    // 创建Form
    var form = $('<form></form>');
    // 设置属性
    form.attr('action', url);
    form.attr('method', 'post');
    // form的target属性决定form在哪个页面提交
    form.attr('target', 'comet_iframe');
    for(var key in data){
        var input = $('<input type="text" name="'+key+'" />');
        input.attr('value',data[key]);
        form.append(input);
    }
    $(document.body).append(form);
    // 提交表单
    form.submit();
}
</script>
<?php
$js = <<<JS
    $(document).on('click', '.setup', function () {
        plugin_action(this,'setup');
        return false;
    });
    
    $(document).on('click', '.unsetup', function () {
        plugin_action(this,'unsetup');
        return false;
    });
    $(document).on('click', '.delete', function () {
        plugin_action(this,'delete');
        return false;
    });
    $('#install-modal').on('hidden.bs.modal', function (e) {
        try{
            top.onMenuChange();    
        }catch (e){
            //todo    
        }
        location.href=oa_timestamp(location.href);
    })
JS;
$this->registerJs($js);
Modal::begin([
'id' => 'install-modal',
'header' => '<div class="modal-title">安装插件: <b>菜单管理</b></div>',
'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
]);
Modal::end();
?>
<iframe name="comet_iframe" id="comet_iframe" src="" style="display: none"></iframe>
