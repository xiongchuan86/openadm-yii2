<?php
/**
 * 配置
 * id,name,type,version 必须且不能为空
 */
return array(
//插件ID 小写字符串 不能重复
'id' => 'hello',
//插件名称 显示用
'name' => 'Hello',
//插件类型 ADMIN|API
'type' => 'ADMIN',
//开发者
'author' => '熊川',
//邮箱
'email'  => 'xiongchuan86@vip.qq.com',
//版本
'version' => '0.1',
//依赖插件
'dependencies' => '',
//小于255个字符
'description' => '这是一个Hello插件这是一个Hello插件这是一个Hello插件这是一个Hello插件这是一个Hello插件这是一个Hello插件',
//只更新文件
'onlyupdatefiles'=>false,
//菜单
'menus' => array(
//子菜单
	'SUBMENU' => array(
			'cfg_value' => '/plugin/hello/video',
			'cfg_pid'   => 17,
			'cfg_comment' => 'Hello',
			'cfg_order' => 5
		),
),
//sql
'execsql' => array()



);
