<?php
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\bootstrap\Button;
$this->params['breadcrumbs'][] = '插件管理';
?>
<style>
.table thead>tr>th, .table tbody>tr>th, .table tfoot>tr>th, .table thead>tr>td, .table tbody>tr>td, .table tfoot>tr>td{font-size:12px;line-height:20px;padding:3px;overflow:hidden;height:20px;}
td{padding:0;}
.pagination{margin:5px 0;}
</style>
<div class="nav-tabs-custom">
<?php echo $this->render('../common/tabs.php');?>
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
			$btn_setup = Button::widget(array(
			    'label'=>'安装',
			    'options'=>array('class' => 'btn-xs btn-success','style'=>'margin-right:10px;','onclick'=>'plugin_action(this,"setup")'),
			),true);
			$btn_unsetup = Button::widget(array(
			    'label'=>'卸载',
			    'options'=>array('class' => 'btn-xs btn-danger','style'=>'margin-right:10px;','onclick'=>'plugin_action(this,"unsetup")'),
			),true);
			$btn_delete = Button::widget(array(
			    'label'=>'删除',
			    'options'=>array('class' => 'btn-xs btn-default','style'=>'','onclick'=>'plugin_action(this,"delete")'),
			),true);
			$btn_update = Button::widget(array(
			    'label'=>'更新',
			    'options'=>array('class' => 'btn-xs btn-info','style'=>'margin-right:10px;','onclick'=>'plugin_action(this,"update")'),
			),true);
			$v['config']['_action_'] = '';
			if($v['setup']){
				$v['config']['_action_'] = $btn_unsetup;
				if($v['update']){
					$v['config']['_action_'] .= $btn_update;
				}
			}else{
				$v['config']['_action_'] = $btn_setup.$btn_delete;
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
    var tr = $(o).parent().parent();
    var id = tr.find("td:first").text();
    $.post('/plugin-manager/ajax',{pluginid:id,action:action,'_csrf':'<?=Yii::$app->request->csrfToken?>'},function(json){
        if(1==json.status){
            noty({text: json.msg,type:'success'});
            setTimeout(function(){location.href=location.href;},1000);
        }else{
            noty({text: json.msg,type:'error'});
        }
    },'json');
}
</script>