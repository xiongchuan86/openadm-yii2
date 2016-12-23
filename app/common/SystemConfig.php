<?php
namespace app\common;
use yii;

/**
 * 获取sytem_config的配置
 * @author xiongchuan <xiongchuan86@gmail.com>
 */
 
class SystemConfig 
{
	static private $_tableName = "%system_config";
	static private $_config = array();

    const TOPMENU_KEY          = "TOPMENU";
    const LEFTMENU_KEY         = "LEFTMENU";
    const INNERMENU_KEY        = "INNERMENU";
    const CONFIG_TYPE_USER     = "USER";
    const CONFIG_TYPE_SYSTEM   = "SYSTEM";
    const CONFIG_TYPE_ROUTE    = "ROUTE";
	
	/**
	 * 返回 array(value=>comment)类型数据
	 * @return array
	 */
	static public function GetArrayValue($name,$pid=0,$type='SYSTEM')
	{
		$array = array();
		$config = self::Get($name,$pid,$type);
		if($config){
			foreach($config as $k=>$v){
				$array[$v['cfg_value']] = $v['cfg_comment'];
			}
		}
		return $array;
	}
	
	static public function GetById($id)
	{
		$sql = "SELECT * FROM {{".self::$_tableName."}} WHERE id=:id";
		$cmd = Yii::$app->db->createCommand($sql);
		$cmd->bindvalue(":id",$id);
		$row = $cmd->queryRow();
		return $row;
	}
	
	/**
	 * 获取配置的数据
	 * @return array
	 */
	static public function Get($name='',$pid=0,$type='SYSTEM')
	{
		$cacheKey = $name.'-'.$pid.'-'.$type;
		
		if(!isset(self::$_config[$cacheKey])){
			$value = self::_Get($name,$pid,$type);
			self::$_config[$cacheKey] = $value;
		}
		return self::$_config[$cacheKey];
	}
	
	/**
	 * @param $name string 配置项的KEY
	 * @param $value array 配置的值
	 * @return int|false  成功返回lastInsertId
	 */
	static public function Set($name,array $value)
	{
		$sql = "INSERT INTO {{".self::$_tableName."}} SET 
				cfg_name    = :cfg_name,
				cfg_value   = :cfg_value,
				cfg_pid     = :cfg_pid,
				cfg_order   = :cfg_order,
				cfg_comment = :cfg_comment,
				ctime       = :ctime,
				cfg_type    = :cfg_type
				";
		$cmd = Yii::$app->db->createCommand($sql);
		$cmd->bindvalue(":cfg_name",$name);
		$cmd->bindvalue(":cfg_value",isset($value['cfg_value']) ? $value['cfg_value'] : '');
		$cmd->bindvalue(":cfg_pid",isset($value['cfg_pid']) ? intval($value['cfg_pid']) : 0);
		$cmd->bindvalue(":cfg_order",isset($value['cfg_order']) ? intval($value['cfg_order']) : 0);
		$cmd->bindvalue(":cfg_comment",isset($value['cfg_comment']) ? $value['cfg_comment'] : '');
		$cmd->bindvalue(":cfg_type",isset($value['cfg_type']) ? $value['cfg_type'] : 'USER');
		$cmd->bindvalue(":ctime",time());
		$status = $cmd->execute();
		if($status){
			$lastid = Yii::$app->db->lastInsertID;
		}
		return $status ? $lastid : false;
	}
	
	/**
	 * 查询配置 支持分页
	 * @return array|boolean
	 * @modify xubaoguo 
	 * @comment add a item to controll a group data
	 */
	static public function GetDataWidthPage($name,$pid,$type,$page=1,$pageSize=50,$status=FALSE){
		$where = " cfg_name=:name ";
		if($status!==FALSE){
			$where .= " AND cfg_status=".$status;
		}
		$pid   = intval($pid);
		if($pid && $pid>0){
			$where .= " AND cfg_pid=:pid ";
		}
		if($type){
			$where .= " AND cfg_type=:type ";
		}

		//分页
		$limit = " ";
		if($page<=0) $page = 1;
		if($pageSize<=0) $pageSize = 50;
		$sql = "SELECT count(*) cnt FROM {{".self::$_tableName."}} WHERE {$where}";
		$cmd = Yii::$app->db->createCommand($sql);
		$cmd->bindvalue(":name",$name);
		if($pid && $pid>0) $cmd->bindValue(":pid",$pid);
		if($type) $cmd->bindValue(":type",$type);
		$row = $cmd->queryRow();
		if($row && $row['cnt']>0){
			$total = $row['cnt'];
			$pages = ceil($total/$pageSize);
			if($page>=$pages) $page = $pages;
			$start = ($page-1)*$pageSize;
			$limit = "LIMIT $start,$pageSize";
			$sql = "SELECT * FROM {{".self::$_tableName."}} WHERE {$where} ORDER BY cfg_order ASC {$limit}";
			$cmd = Yii::$app->db->createCommand($sql);
			$cmd->bindvalue(":name",$name);
			if($pid && $pid>0) $cmd->bindValue(":pid",$pid);
			if($type) $cmd->bindValue(":type",$type);
			$rows = $cmd->queryAll();
			if($rows){
				$result = array(
					'total' => $total,
					'page'  => $page,
					'pageSize' => $pageSize,
					'pages' => $pages,
					'data'  => $rows
				);
				return $result;
			}
		}
		return false;
	}
	 
	
	/**
	 * 查询配置
	 * @return array|boolean
	 */
	static private function _Get($name='',$pid,$type){
		$where = " 1 ";
		$pid   = intval($pid);
		if($name){
			$where .= " AND cfg_name=:name ";
		}
		if($pid && $pid>0){
			$where .= " AND cfg_pid=:pid ";
		}
		if($type){
			$where .= " AND cfg_type=:type ";
		}
		$sql = "SELECT * FROM {{".self::$_tableName."}} WHERE {$where} ORDER BY cfg_order ASC";
		$cmd = Yii::$app->db->createCommand($sql);
		if($name)$cmd->bindvalue(":name",$name);
		if($pid && $pid>0) $cmd->bindValue(":pid",$pid);
		if($type) $cmd->bindValue(":type",$type);
		$rows = $cmd->queryAll();
		return $rows;
	}
	
	/**
	 * 通过id更新配置
	 * @param $id int   主键
	 * @param $value array 值
	 * @return boolean
	 */
	static public function Update($id,array $value)
	{
        if($id && $id>0){
            $defaultFields = ['cfg_name','cfg_value','cfg_pid','cfg_order','cfg_comment'];
            $useFields     = [];
            foreach ($value as $key=>$val){
                if(in_array($key,$defaultFields)){
                    $useFields[$key] = $key."=:".$key;
                }
            }
            if(count($useFields)>0){
                $sql = "UPDATE {{".self::$_tableName."}} SET ". join(",",$useFields) ." WHERE   id  = :id LIMIT 1";
                //echo $sql . "\n";
                $cmd = Yii::$app->db->createCommand($sql);
                foreach ($useFields as $key=>$v){
                    $cmd->bindvalue(":".$key,isset($value[$key]) ? $value[$key] : '');
                }
                $cmd->bindvalue(":id",$id);
                return $cmd->execute();
            }
        }
		return false;
	}
	/*
	 * 通过id 修改显示状态
	 * @param $id int   主键
	 * @return boolean
	 * 
	 * */
	 static public function changeStauts($id){
	 	$sql = "SELECT * FROM {{".self::$_tableName."}} WHERE id=:id";
		$res = Yii::$app->db->createCommand($sql)->bindValue(':id',$id)->queryRow();
		if(1 == $res['cfg_status']){
			$newStatus = 0;
		}else{
			$newStatus = 1;
		}
		$sql_update = "UPDATE {{".self::$_tableName."}} 
						SET cfg_status=:status
						WHERE id=:id;
		";
		$result = Yii::$app->db->createCommand($sql_update)->bindValues(array(":id"=>$id,":status"=>$newStatus))->execute();
				
	 }
	/**
	 * 移除配置
	 * @param $id int  主键
	 * @return boolean
	 */
	static public function Remove($id)
	{
		$sql = "DELETE FROM {{".self::$_tableName."}} WHERE   id  = :id LIMIT 1";
		$cmd = Yii::$app->db->createCommand($sql);
		$cmd->bindvalue(":id",$id);
		return $cmd->execute();
	}

    /**
     * openadm的版本号
     * @return string OpenAdm 框架版本号
     */
	static public function getVersion()
    {
        return "0.1";
    }
}
