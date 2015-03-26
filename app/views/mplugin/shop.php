<style>
.table thead>tr>th, .table tbody>tr>th, .table tfoot>tr>th, .table thead>tr>td, .table tbody>tr>td, .table tfoot>tr>td{font-size:12px;line-height:20px;padding:3px;overflow:hidden;height:20px;}
.summary{text-align:right;}
td{padding:0;}
.pagination{margin:5px 0;}
</style>
<ol class="breadcrumb">
  	<li class="active" >插件商城</li>
</ol>
<div class="box"><div class="box-content">
	<?php 
		$dataProvider=new CArrayDataProvider(array());
	     $this->widget('bootstrap.widgets.TbGridView', array(
		'type'=>'striped bordered condensed',
	    'dataProvider'=>$dataProvider,	    
	   	'pager' => array('class'=>'bootstrap.widgets.TbPager','displayFirstAndLast'=>true,'htmlOptions'=>array('class'=>'pagination')),
	    'cssFile'=>'',
	    'columns'=>array(
        array(      
            'name'=>'id',
            'value'=>'$data->id',
            'htmlOptions'=>array('style'=>'width:6%;'),
        ),
        array(      
            'name'=>'name',
            'header'=>'名称',
            'value'=>'$data->id',
            'htmlOptions'=>array('style'=>'width:6%;'),
        ),
        array(      
            'name'=>'type',
            'header'=>'类型',
            'value'=>'$data->id',
            'htmlOptions'=>array('style'=>'width:6%;'),
        ),
        array(      
            'name'=>'version',
            'header'=>'版本',
            'value'=>'$data->id',
            'htmlOptions'=>array('style'=>'width:6%;'),
        ),
        array(      
            'name'=>'summary',
            'header'=>'简介',
            'value'=>'$data->id',
            'htmlOptions'=>array('style'=>'width:6%;'),
        ),
        
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{update}{delete}{addtv}',
            'htmlOptions'=>array('style'=>'width:15%;'),
            'header'=>'操作',
            'buttons'=>array(

                 'update'=>array(
                    'label'=>'修改',
                    'icon' => 'inverse',
                    'options'=>array('style'=>'padding-right:10px;'),
                                   
                ),
                 'delete'=>array(
                    'label'=>'删除',
                    'icon' => 'danger',
                    'options'=>array('style'=>'padding-right:10px;'),
                                   
                ),
                            
                'addtv'=>array(
                    'label'=>"加分集",
                    'icon'=>'success',
                    'options'=>array('style'=>'padding-right:10px;'),
                ),
            ),
        ),
    ),
    'ajaxUpdate'=> false,  
));

	?>
</div></div>
<script type="text/javascript">
    $(document).ready(function(){
        /*$.ajax({
             url:'',
             dataType:"jsonp",
             jsonp:"callback",
             success:function(){
             }
        });*/
        $.post('/admin/pluginManager/getPlugin',{},function(data){
        	callback(data);
        },'json')
    });
    function callback(data){
    	if(data!=undefined && data!=''){
    		$('.empty').remove();
    	}
    	var str = '';
    	var methods = 'add';
    	var buttonName = '下载';
    	$.each(data,function(k,v){
    		//下载状态   1 已下载已安装  2 更新  3 未下载
    		if(1==v.downloadStatus){
    			buttonName = '已下载';
    			methods    = 'setup';
    		}else if(2==v.downloadStatus){
    			buttonName = '更新';
    			methods    = 'update';
    		}else if(3==v.downloadStatus){
    			buttonName = '下载';
    			methods    = 'add';
    		}
    		func = "downloads('"+v.url+"','"+methods+"')";
    		buttons = '<a class="btn btn-primary btn-xs" id="yw1" onclick="'+func+'" style="margin-right:10px;">'+buttonName+'</a>';
    		str += '<tr class="old"><td>'+v.en_code+'</td><td>'+v.name+'</td><td>'+v.type+'</td><td>'+v.version+'</td><td>'+v.summary+'</td><td>'+buttons+'</td></tr>'
    	})
    	$(".items tbody").append(str);
    }
    function downloads(url,method){
    	$.post('/admin/pluginManager/downloadPlugin',{url:url,method:method},function(data){
    		alert(data.msg);
    		if(1 == data.status){
    			window.location.href="/admin/pluginManager/local";
    		}
    	},'json')
    }
</script>