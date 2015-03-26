<?php

use yii\db\Schema;
use yii\db\Migration;
use yii\base\ErrorException;

class m150326_082211_import_db extends Migration
{
    public function safeUp()
    {
		$file = dirname(__FILE__)."/mysql.sql";
		if(is_file($file)){
			$dbname = $this->getDbName();
			$tableprefix = $this->db->tablePrefix;
			$sql = file_get_contents($file);
			$arr1 = ['{dbname}','{tableprefix}'];
			$arr2 = [$dbname,$tableprefix];
			if($dbname){
				$sql = str_replace($arr1, $arr2, $sql);
				try{
					$this->execute($sql);
					echo "导入数据库文件成功:".$file."\n";
					return true;
				}catch(ErrorException $e){
					print_r($e->getMessage());
					return false;
				}
			}else{
				echo "请配置数据库连接\n";
			}
			
		}else{
			echo "没有可以恢复的数据库文件\n";
		}
		return false;
    }

	public function getDbName()
	{
		$pattern = "/dbname=([^;]*);?/i";
		if(preg_match($pattern, $this->db->dsn,$m)){
			return $m[1];
		}
		return false;
	}

    public function down()
    {
        echo "m150326_082211_import_db cannot be reverted.\n";

        return false;
    }
    
}
