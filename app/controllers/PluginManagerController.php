<?php
namespace app\controllers;

use Yii;
use app\common\Controller;
use app\common\SystemConfig;
use app\models\PluginManager;
use app\common\SystemEvent;

class PluginManagerController extends Controller
{
	//plugin list
	public function actionIndex()
	{
		$this->redirect("local");
	}
	
	public function actionLocal($pid,$tab = "all",$page=1)
	{
		$tab = in_array($tab,array('all','setuped','new')) ? $tab : 'all';
		$tabs = SystemConfig::Get("THIRDMENU",$pid,"USER");
		//获取插件
		$pageSize = 20;
		$result = PluginManager::GetPlugins($tab,$page,$pageSize);
		return $this->render("local",array('tabs'=>$tabs,'tab'=>$tab,'result'=>$result));
	}
	
	public function actionShop()
	{
		$url = Yii::app()->params['boss'].'/admin/plugin/GetPlugin/token/'.Yii::app()->params['token'];
		$this->render("shop",array('url'=>$url));
	}
	public function actionGetPlugin(){
		//下载状态   1 已下载已安装  2 更新  3 未下载
		$url = Yii::app()->params['boss'].'/admin/plugin/GetPlugin/token/'.Yii::app()->params['token'];
		$content = Curl::curlRequest($url,'');
		$plugins = json_decode($content,TRUE);
		$locals  = PluginManager::GetPlugins('all',1,1000000);
		$localPluginId = is_array($locals['data']) ? array_keys($locals['data']) : array();
		if(is_array($plugins))foreach ($plugins as $key => $item) {
			if(in_array($item['en_code'], $localPluginId)){
				if($item['version']!=$locals['data'][$item['en_code']]['config']['version']){
					$plugins[$key]['downloadStatus'] = 2;
				}else{
					$plugins[$key]['downloadStatus'] = 1;
				}
			}else{
				$plugins[$key]['downloadStatus'] = 3;
			}		
		}
		echo json_encode($plugins);die;
	}
	//ajax
	public function actionAjax()
	{
		$result = array(
			'status'=>0,
			'msg'=>'缺少参数'
		);
		if(!empty($_POST)){
			$action = isset($_POST['action']) ? $_POST['action'] : '';
			$pluginid = isset($_POST['pluginid']) ? $_POST['pluginid'] : '';
			if($pluginid && $action){
				$result = PluginManager::$action($pluginid);
			}
		}
		echo json_encode($result);
	}
	
	//download plugin
	private function _download($domain,$path,$times=1)
	{
		if($times>4){
			return FALSE;
		}
		$url   = $domain.'/'.$path;
		$local =  Yii::app()->BasePath.'/../'.$path;
		//curl 获取插件
        $plugin = Curl::downloadFile($url);

		//--------------------------------------
		$fileName = trim(strrchr($local,'/'),'/');
		$paths = str_replace($fileName,'',$local);
		if (!file_exists($paths) || !is_writable($paths)) {
			@mkdir($paths, 0777,true);
		}
		$stream = @fopen($paths.$fileName, 'xb');
		if($stream){
			fwrite($stream,$plugin);
			fclose($stream);
		}else{
			$times++;
			$zipFile = $path.$fileName;
			$fileHanlder = Yii::app()->file->set($zipFile,true);
			$f = $fileHanlder->delete();
			$this->_download($domain, $path , $times);
		}
		return $local;
	}
	private function _unzip($local,$method){
		$archive = new PclZip($local);
		$tmpPath  = Yii::app()->BasePath.'/../upload/tmp/';
		if(($v_result_list = $archive->extract(PCLZIP_OPT_PATH,$tmpPath)) == 0) {
			return "Error : ".$archive->errorInfo(true);
		}
		$pluginId = strtolower(trim($v_result_list[0]['stored_filename'],DIRECTORY_SEPARATOR));
		if("add"==$method){
			$oldController = $v_result_list[0]['filename'].'controllers';
			$newController = Yii::app()->BasePath.'/modules/plugin/controllers';
			$oldSrc = $v_result_list[0]['filename'].'src';
			$newSrc = Yii::app()->BasePath.'/modules/plugin/src';
			$count  = $this->_copy_merge ( $oldController, $newController );
			$count += $this->_copy_merge ($oldSrc, $newSrc);
		}elseif("update"==$method){
			$oldController = $v_result_list[0]['filename'].'controllers';
			$oldSrc = $v_result_list[0]['filename'].'src/'.$pluginId;
			$newUpdate = Yii::app()->BasePath.'/modules/plugin/src/'.$pluginId.'/update';
			$count  = $this->_copy_merge ( $oldController, $newUpdate );
			$count += $this->_copy_merge ( $oldSrc, $newUpdate);
		}
		
		return (int)$count;
	}
	private function _copy_merge($source, $target) {
    	// 路径处理
	    $source = preg_replace ( '#/\\\\#', DIRECTORY_SEPARATOR, $source );
	    $target = preg_replace ( '#\/#', DIRECTORY_SEPARATOR, $target );
	    $source = rtrim ( $source, DIRECTORY_SEPARATOR ) . DIRECTORY_SEPARATOR;
	    $target = rtrim ( $target, DIRECTORY_SEPARATOR ) . DIRECTORY_SEPARATOR;
   		// 记录处理了多少文件
	    	$count = 0;
	    // 如果目标目录不存在，则创建。
	    if (! is_dir ( $target )) {
	        mkdir ( $target, 0777, true );
	        $count ++;
	    }
	    // 搜索目录下的所有文件
	    foreach ( glob ( $source . '*' ) as $filename ) {
	        if (is_dir ( $filename )) {
	            // 如果是目录，递归合并子目录下的文件。
	            $count += $this->_copy_merge ( $filename, $target . basename ( $filename ) );
	        } elseif (is_file ( $filename )) {
	            // 如果是文件，判断当前文件与目标文件是否一样，不一样则拷贝覆盖。
	            // 这里使用的是文件md5进行的一致性判断，可靠但性能低，应根据实际情况调整。
	            if (! file_exists ( $target . basename ( $filename ) ) || md5 ( file_get_contents ( $filename ) ) != md5 ( file_get_contents ( $target . basename ( $filename ) ) )) {
	                copy ( $filename, $target . basename ( $filename ) );
	                $count ++;
	            }
	        }
	    }
	    // 返回处理了多少个文件
	    return $count;
	}
	public function actionDownloadPlugin(){
		$result['status'] = 0;
		$url  = $this->getParam('url');
		$boss = SystemConfig::Get('SYSTEM_BOSS_DOMAIN',NULL,'USER');
		$method  = $this->getParam('method');
		if($boss){
			$bossUrl = $boss[0]['cfg_value'];
			$local   = $this->_download($bossUrl,$url);
			if($local){
				$count   = $this->_unzip($local,$method);
				if(is_integer($count)){
					$result['status'] = 1;
					if('add'==$method){
						$result['msg'] = '下载插件成功';
					}elseif("update"==$method){
						$result['msg'] = '更新插件成功';
					}
				}else{
					$result['msg'] = $count;
				}
			}else{
				$result['msg'] = '与boss系统通信失败，请检查boss系统网址配置和服务器网络状况！';
			}
		}else{
			$result['msg'] = '您还没有配置BOSS系统地址！';
		}
		echo json_encode($result);die;
	}
}