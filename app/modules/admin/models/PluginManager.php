<?php
/**
 * 插件管理者
 * 插件id,插件目录，必须为小写
 * @author xiongchuan <xiongchuan@luxtonenet.com>
 */
namespace app\modules\admin\models;
use yii;
use app\common\SystemConfig;
use yii\helpers\FileHelper;
use yii\base\ErrorException;
use yii\helpers\Json;
use yii\base\InvalidParamException;
use yii\helpers\Html;

class PluginManager
{
    const STATUS_SUCCESS = 1;
    const STATUS_ERROR   = 0;
    const ERROR_NEEDED   = 110;
    const ERROR_NOTATLOCAL = 120;
    const ERROR_MIGRATE = 130;

    const PLUGIN_TYPE_ADMIN = "ADMIN";
    const PLUGIN_TYPE_API   = "API";
    const PLUGIN_TYPE_HOME  = "HOME";

    const PLUGIN_CONFIG_ID_RECORD_KEY = "PLUGIN_CONFIG_IDS";

    static private $_plugins = array();
    static private $_setupedplugins = array();

    const YII_COMMAND   = '@root/yii';
    const MIGRATE_UP    = 'up';
    const MIGRATE_DOWN  = 'down-plugin';//重写数据库清楚操作
    const MIGRATION_DEFAULT_DIRNAME = 'migrations';

    static public $isShowMsg = 0;

    static public function setShowMsg($value)
    {
        static::$isShowMsg = $value;
    }

    /**
     * 此处的输出方式 要配合 iframe输出
     *
     * 具体使用参看:@app/themes/adminlte2/views/plugin-manager/local.php
     *
     * <code>
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
     * </code>
     *
     * @param $msg
     * @param int $rn
     * @param string $type
     * @param string $boxId
     */
    static public function showMsg($msg,$rn=1,$type='info',$boxId='')
    {
        if(!static::$isShowMsg){
            return;
        }
        $color='';
        switch ($type){
            case 'info':
                $color='';
                break;
            case 'success':
                $color = 'green';
                break;
            case 'error':
                $color = 'red';
                break;
            default:
                break;

        }
        if($color){
            $str = "<span style=\"color:{$color}\">$msg</span>".($rn == 1 ? '<br />' : '');
        }else{
            $str = "$msg".($rn == 1 ? '<br />' : '');
        }

        $str = str_replace(["'","\n"],["\"",""],$str);
        echo "<script>parent.onmessage('$str','$boxId');</script>";
        ob_flush();
        flush();
    }

    /**
     * 获取已经安装的插件
     */
    static public function GetSetupedPlugins()
    {
        if(empty(static::$_setupedplugins)){
            $plugins = SystemConfig::Get('',null,SystemConfig::CONFIG_TYPE_PLUGIN);
            foreach ($plugins as $plugin){
                try{
                    static::$_setupedplugins[$plugin['cfg_name']] = Json::decode($plugin['cfg_value'],true);
                }catch (InvalidParamException $e){
                    static::$_setupedplugins[$plugin['cfg_name']] = $plugin['cfg_value'];
                }
            }
        }
        return static::$_setupedplugins;
    }

    static public function PluginSetupedCompleted($pluginid,array $config)
    {
        $record_key = isset(static::$_plugins[$pluginid][static::PLUGIN_CONFIG_ID_RECORD_KEY]) ? static::$_plugins[$pluginid][static::PLUGIN_CONFIG_ID_RECORD_KEY] : [];
        $cfg_value = Json::encode(array_merge($config,[static::PLUGIN_CONFIG_ID_RECORD_KEY=>$record_key]));
        $params = array(
            'cfg_value'   => $cfg_value,
            'cfg_comment' => $config['name'],
            'cfg_type'    =>SystemConfig::CONFIG_TYPE_PLUGIN
        );
        SystemConfig::Set($pluginid,$params);
        return true;
    }


    /**
     * 获取单个plugin的config
     * @param $pluginid string
     * @param $cache 是否缓存
     * @param $dir string  实时获取配置
     * @param $checkDependency 是否检查依赖插件
     */
    static public function GetPluginConfig($pluginid,$cache=true,$dir=null,$checkDependency = true)
    {
        $dir = $dir ? $dir : static::GetPluginPath($pluginid);
        $config = array(
            'setup'  => static::IsSetuped($pluginid),
            'config' => false
        );
        $pluginconfigfile = $dir ."/config.php";
        if(is_file($pluginconfigfile)){
            if(!static::ParsePluginConfig($pluginid))return false;
            $config['config'] = require $pluginconfigfile;
            //检查依赖插件
            if($checkDependency){
                static::CheckDependency($config['config']);
            }
        }
        if($cache){
            static::$_plugins[$pluginid] = $config;
        }
        return $config;
    }

    /**
     *
     * 获取本地的全部插件
     * 支持分页显示
     * @param $type string  all:全部,setuped:安装的,new:新的
     * @param $page int
     * @param $pageSize int
     * @return array|boolean
     */
    static public function GetPlugins($type="all",$page=1,$pageSize=20)
    {
        //获取数据源
        $setupedplugins = static::GetSetupedPlugins();
        if("setuped"==$type){
            $fileArray = array_map('strtolower',array_keys($setupedplugins));
        }else{
            $pluginDir = Yii::getAlias('@plugins');
            $fileArray = array_slice(scandir($pluginDir,0),2);//过滤掉.|..目录
            //改写fileArray
            if("new" == $type){
                $setuped = array_map('strtolower',array_keys($setupedplugins));
                $fileArray = array_diff($fileArray, $setuped);
            }
        }//获取数据源结束

        //对分页进行边界判断
        if($pageSize <=0){
            $pageSize = 20;
        }
        $total = count($fileArray);
        $pages = ceil($total/$pageSize);
        if($page<=0){
            $page = 1;
        }
        if($page>=$pages){
            $page = $pages;
        }
        //分页判断结束
        $start = ($page-1)*$pageSize;
        $fileArraySlice = array_slice($fileArray, $start,$pageSize);

        if(!empty($fileArraySlice)){
            foreach($fileArraySlice as $pluginid){
                //过滤不合格的plugin
                if(!static::ParsePluginConfig($pluginid)){
                    continue;
                }
                static::$_plugins[$pluginid] = array(
                    'setup'  => static::IsSetuped($pluginid),
                    'config' => false
                );
                $pluginconfigfile = static::GetPluginPath($pluginid)."/config.php";
                if(is_file($pluginconfigfile)){
                    static::$_plugins[$pluginid]['config'] = require $pluginconfigfile;
                    //检查依赖插件
                    static::CheckDependency(static::$_plugins[$pluginid]['config']);
                }
            }
            $result = array(
                'page' => $page,
                'pageSize' => $pageSize,
                'total' => $total,
                'pages' => $pages,
                'data'  => static::$_plugins
            );
            return $result;
        }
        return false;
    }


    /**
     * 获取插件路径
     */
    static public function GetPluginPath($pluginid)
    {
        return Yii::getAlias('@plugins').DIRECTORY_SEPARATOR.strtolower($pluginid).DIRECTORY_SEPARATOR;
    }

    /**
     * 删除静态变量数组里面的值
     */
    static public function PluginDeleteStaticVar($pluginid)
    {
        if(!empty(static::$_setupedplugins)){
            unset(static::$_setupedplugins[$pluginid]);
        }
    }

    /**
     * 判断是否已经安装
     */
    static public function IsSetuped($pluginid)
    {
        if(empty(static::$_setupedplugins)){
            static::GetSetupedPlugins();
        }
        return isset(static::$_setupedplugins[$pluginid]) ? 1 : 0;
    }

    /**
     * 检测依赖关系
     */
    static public function CheckDependency(array &$config)
    {
        $unsetuped = array();
        if(is_array($config)){
            $dependencies = isset($config['dependencies']) ? $config['dependencies'] : '';
            $array = $dependencies ? explode(",", $dependencies) : '';
            if(!empty($array)){
                static::showMsg('');
                foreach($array as $pluginid){
                    if($pluginid){
                        static::showMsg('|___检测依赖插件:'.$pluginid.'是否安装...',0);
                        if(0 == static::IsSetuped($pluginid)){
                            $unsetuped[] = $pluginid;
                            static::showMsg('未安装',1,'error');
                        }else{
                            static::showMsg('已安装',1,'success');
                        }
                    }
                }
            }
        }
        $config['needed'] = join(",",$unsetuped);
    }

    /**
     * 插件注入route
     */
    static public function PluginInjectRoute(array $conf)
    {
        if(isset($conf['route']) && !empty($conf['route']) && is_array($conf['route'])){
            $params = [
                'cfg_value'   => Json::encode($conf['route']),
                'cfg_comment' => $conf['id'],
                'cfg_pid'     => 0,
                'cfg_order'   => 0,
                'cfg_type'    => 'ROUTE'
            ];
            $cfg_name = strtoupper("plugin_{$conf['id']}_route");
            $lastid = SystemConfig::Set($cfg_name,$params);
            static::RecordPluginConfigId($conf['id'],$lastid);
        }
    }

    /**
     * 把config注入到system_config
     * @param array $conf
     */
    static public function PluginInjectConfig(array $conf)
    {
        if(isset($conf['config']) && !empty($conf['config']) && is_array($conf['config'])){
            foreach ($conf['config'] as $config){
                if(isset($config['cfg_name']) && !empty($config['cfg_name'])){
                    $params = [
                        'cfg_name'  => $config['cfg_name'],
                        'cfg_value' => isset($config['cfg_value']) ? $config['cfg_value'] : '',
                        'cfg_comment' => isset($config['cfg_comment']) ? $config['cfg_comment'] : '',
                    ];
                    $lastid = SystemConfig::Set($config['cfg_name'],$params);
                    static::RecordPluginConfigId($conf['id'],$lastid);
                }
            }
        }
    }

    /**
     * 安装过程中,记录_pluings[pluginId] = ['config_ids'=>[]]
     * @param $pluginId plugin id
     * @param $configId system_config id
     */
    static public function RecordPluginConfigId($pluginId,$configId)
    {
        if( $configId>0){
            if(!isset(static::$_plugins[$pluginId])){
                static::$_plugins[$pluginId] = [];
            }
            if(!isset(static::$_plugins[$pluginId][static::PLUGIN_CONFIG_ID_RECORD_KEY])){
                static::$_plugins[$pluginId][static::PLUGIN_CONFIG_ID_RECORD_KEY] = [];
            }
            array_push(static::$_plugins[$pluginId][static::PLUGIN_CONFIG_ID_RECORD_KEY],$configId);
        }
    }

    /**
     * 实际注入方法
     * @param $pluginId
     * @param $cfg_name
     * @param array $menus
     */
    static public function _PluginInjectMenu($pluginId,$cfg_pid,array $menus)
    {
        $plugin_last_config = static::PluginLastSavedConfig($pluginId);
        foreach ($menus as $menu){
            $params = [
                'cfg_value'   => isset($menu['cfg_value']) ? $menu['cfg_value'] : '',
                'cfg_comment' => isset($menu['cfg_comment']) ? $menu['cfg_comment'] : '',
                'cfg_pid'     => $cfg_pid ==0 ? (isset($menu['cfg_pid']) ? $menu['cfg_pid'] : 0) : $cfg_pid,
                'cfg_order'   => isset($menu['cfg_order']) ? $menu['cfg_order'] : 0
            ];
            //使用旧的配置信息
            if(!empty($plugin_last_config) && isset($plugin_last_config['menus']) && isset($plugin_last_config['menus'][$params['cfg_comment']])){
                $params['cfg_pid'] = $plugin_last_config['menus'][$params['cfg_comment']]['cfg_pid'];
                $params['cfg_order'] = $plugin_last_config['menus'][$params['cfg_comment']]['cfg_order'];
            }

            if(empty($params['cfg_value']) || empty($params['cfg_comment']))continue;
            //检查cfg_value是否为数组,并且有url,icon(可选)
            if(is_array($params['cfg_value']) && isset($params['cfg_value']['url'])){
                $params['cfg_value'] = Json::encode($params['cfg_value']);
            }else{
                continue;//不满条件,就继续foreach
            }
            //写入system_config表
            $lastPuginConfigId = SystemConfig::Set(SystemConfig::MENU_KEY,$params);
            static::RecordPluginConfigId($pluginId,$lastPuginConfigId);

            //检查是否有子菜单
            if(isset($menu['items']) && is_array($menu['items'])){
                static::_PluginInjectMenu($pluginId,$lastPuginConfigId,$menu['items']);
            }
        }

    }

    /**
     * 注入Plugin的数据库操作
     * @param $pluginid pluginid
     * @param $type up/down up=创建,down=回退
     */
    static public function PluginInjectMigration($pluginid,$type)
    {
        $configRaw = static::GetPluginConfig($pluginid,true,null,false);
        $conf      = $configRaw['config'];
        if(!$conf){
            //plugin 目录异常
            static::showMsg("");
            static::showMsg("获取插件配置失败,请检查插件是否正常!",1,'error');
            return false;
        }
        if(isset($conf['migrationDirName']) && !empty($conf['migrationDirName'])){
            $migrationDirName = $conf['migrationDirName'];
        }else{
            $migrationDirName = static::MIGRATION_DEFAULT_DIRNAME;
        }
        //检查是否需要migrate操作,原则是看是否有migrations目录
        $migrationPath = Yii::getAlias('@plugins/'.$pluginid.'/'.$migrationDirName);
        if(is_dir($migrationPath)){
            static::showMsg("需要",1,'success');
            static::showMsg("开始执行Migrate操作...");
            $yii = Yii::getAlias(static::YII_COMMAND);
            //--interactive=0 非交互式命令行
            $params = "--migrationPath=$migrationPath --interactive=0";
            $action = "migrate/";
            switch ($type){
                case static::MIGRATE_UP:
                    $action .= static::MIGRATE_UP;
                    break;
                case static::MIGRATE_DOWN:
                    $action .= static::MIGRATE_DOWN;
                    break;
                default:
                    break;
            }
            $cmds = [
                $yii,
                $action,
                $params
            ];
            $cmd = join(" ",$cmds);
            static::showMsg("<p id='cmd_box' style='background-color: #2c763e;color:#f5db88'>",0);
            //执行
            $handler = popen($cmd, 'r');
            static::showMsg("cmd:  ".$cmd."\n",1,'','cmd_box');
            while (!feof($handler)) {
                $output = fgets($handler,1024);
                static::showMsg($output,1,'','cmd_box');
            }
            pclose($handler);

            static::showMsg("</p>",0);
        }else{
            static::showMsg("不需要",1,'success');
        }
        return true;
    }

    /**
     * 插件菜单注入
     */
    static public function PluginInjectMenu(array $conf)
    {
        $pluginId = $conf['id'];
        if(isset($conf['menus']) && is_array($conf['menus']) && !empty($conf['menus'])){
            static::_PluginInjectMenu($pluginId,0,$conf['menus']);
        }
    }

    static public function SetupLocalPlugin($pluginName)
    {
        //解析配置
        $config = static::ParsePluginConfig($pluginName);
        //根据配置执行操作
        foreach ($config as $action => $conf) {
            if(method_exists(self, $action)){
                static::$action($conf);
            }
        }
    }

    /**
     * 解析配置
     */
    static public function ParsePluginConfig($pluginid,$conf=null)
    {
        if(is_array($conf)){
            $config = $conf;
        }else{
            $configfile = static::GetPluginPath($pluginid)."/config.php";
            if(!is_file($configfile))return false;
            $config = require $configfile;
        }
        //pluginidController的pluginid要和pluginid.php里面的id值相等
        if(!isset($config['id']) || $pluginid != $config['id']){
            return false;
        }
        if(!isset($config['version']) ||
            !isset($config['name']) ||
            !isset($config['type']) ||
            empty($config['version']) ||
            empty($config['name']) ||
            empty($config['type'])
        ){
            return false;
        }
        return true;
    }

    /**
     * 移除插件在system_config里面的配置
     * @param $pluginid string
     */
    static public function PluginDeleteDBConfig($pluginid)
    {
        $plugins = SystemConfig::Get($pluginid,null,SystemConfig::CONFIG_TYPE_PLUGIN);
        if($plugins && is_array($plugins))foreach ($plugins as $plugin){
            try{
                $value = Json::decode($plugin['cfg_value']);
                $config_ids = isset($value[static::PLUGIN_CONFIG_ID_RECORD_KEY]) ? $value[static::PLUGIN_CONFIG_ID_RECORD_KEY] : [];
                if(is_array($config_ids) && !empty($config_ids))foreach ($config_ids as $id){
                    $configRaw = SystemConfig::GetById($id);
                    if($configRaw && in_array($configRaw['cfg_name'],[SystemConfig::MENU_KEY,SystemConfig::HOMEMENU_KEY])){
                        static::PluginSaveOldConfig($pluginid,$configRaw);
                    }
                    SystemConfig::Remove($id);
                }
            }catch (InvalidParamException $e){

            }
            //删除自己
            SystemConfig::Remove($plugin['id']);
        }
        return false;
    }

    /**
     * 卸载前 把插件的配置保存,以便下次安装的时候可以使用之前配置好的参数
     * @param $pluginid
     * @param $config
     */
    static public function PluginSaveOldConfig($pluginid,$config)
    {
        static::showMsg('<br/>保存插件配置信息到插件目录...');
        $Dir = static::GetPluginPath($pluginid).'unsetup/';
        if(!is_dir($Dir)){
            @mkdir($Dir,0777);
        }
        $old_config_path = $Dir.'unsetup_save_config.php';
        if(!is_file($old_config_path)){
            @file_put_contents($old_config_path,'');
        }
        if(is_writable($Dir) && is_writable($old_config_path)){
            $content = file_get_contents($old_config_path);
            $save_config = [];
            if($content){
                try{
                    $save_config = Json::decode($content,true);
                }catch (InvalidParamException $e){
                }
            }
            if( is_array($save_config) ){
                if(!isset($save_config["menus"])){
                    $save_config["menus"] = [];
                }
            }else{
                $save_config = [];
                $save_config["menus"] = [];
            }
            $save_config["menus"][$config['cfg_comment']] = $config;
            file_put_contents($old_config_path,Json::encode($save_config));
            static::showMsg("配置路径:$old_config_path ... 保存完成!");
        }else{
            static::showMsg("配置路径:$old_config_path ... 不可写, 跳过!");
        }
    }

    /**
     * 获取插件之前保存的配置信息
     * @param $pluginid
     * @return array|mixed
     */
    static public function PluginLastSavedConfig($pluginid)
    {
        $path = static::GetPluginPath($pluginid).'unsetup/unsetup_save_config.php';
        $save_config = [];
        if(is_file($path)){
            $content = file_get_contents( $path );
            try{
                $save_config = Json::decode($content,true);
            }catch (InvalidParamException $e){
            }
        }
        return $save_config;
    }


    /**
     * 安装插件
     * @param $pluginid
     */
    static public function setup($pluginid)
    {
        static::showMsg("开始安装插件...");
        $data = array("status"=>static::STATUS_ERROR,'msg'=>'未知错误');
        //检查是否已经安装
        if( 0 == static::IsSetuped($pluginid)){
            static::showMsg("获取插件配置...",0);
            $configRaw = static::GetPluginConfig($pluginid,false,null,false);//关闭这里的插件检测
            $config = $configRaw['config'];
            static::showMsg("完成",1,'success');
            static::showMsg("检测插件依赖...",0);
            static::CheckDependency($config);//在这里检测插件依赖
            if(isset($config['needed']) && !empty($config['needed'])){
                static::showMsg("");
                static::showMsg("请先安装缺失的依赖插件:{$config['needed']}，再安装此插件！",1,'error');
                $data['status'] = static::STATUS_ERROR;
                $data['error_no'] = static::ERROR_NEEDED;
                $data['msg']      = "请先安装缺失的依赖插件，再安装此插件！";
                return $data;
            }
            static::showMsg("检测完成",1,'success');
            if($config){
                static::showMsg("检测是否需要执行Migrate...",0);
                //导入数据表
                $rn = static::PluginInjectMigration($pluginid,static::MIGRATE_UP);
                if(!$rn){
                    $data['status'] = static::STATUS_ERROR;
                    $data['error_no'] = static::ERROR_MIGRATE;
                    $data['msg']      = "插件Migrate失败,请检查插件Migration配置!";
                    return $data;
                }
                static::showMsg("开始注册菜单...",0);
                //注入菜单
                static::PluginInjectMenu($config);
                static::showMsg("完成",1,'success');
                static::showMsg("开始注册路由...",0);
                //注入route
                static::PluginInjectRoute($config);
                static::showMsg("完成",1,'success');
                static::showMsg("开始注册系统配置...",0);
                //注入config
                static::PluginInjectConfig($config);
                static::showMsg("完成",1,'success');
                static::showMsg("保存插件信息到数据库...",0);
                //完成最后操作
                static::PluginSetupedCompleted($pluginid,$config);
                static::showMsg("完成",1,'success');
                $data['status'] = static::STATUS_SUCCESS;
                $data['msg'] = "安装成功";
                static::showMsg("插件安装完成",1,'success');
                return $data;
            }else{
                static::showMsg("插件配置文件解析错误,请重新下载后解压到插件目录！",1,'error');
                //需要去插件商城下载
                $data['status'] = static::STATUS_ERROR;
                $data['error_no'] = static::ERROR_NOTATLOCAL;
                $data['msg']      = "插件在本地不存在，请去插件商城下载安装！";
                return $data;
            }
        }else{
            static::showMsg("插件已经安装!",1,'success');
            $data = array("status"=>static::STATUS_ERROR,'msg'=>'已经安装了');
        }
        return $data;
    }

    /**
     * 卸载插件
     * @param $pluginid
     */
    static public function unsetup($pluginid)
    {
        static::showMsg('开始卸载插件...');
        static::showMsg('检测是否需要执行Migrate...',0);
        $rn = static::PluginInjectMigration($pluginid,static::MIGRATE_DOWN);
        if(!$rn){
            $data['status'] = static::STATUS_ERROR;
            $data['error_no'] = static::ERROR_MIGRATE;
            $data['msg']      = "插件Migrate失败,请检查插件Migration配置!";
            return $data;
        }
        static::showMsg('删除数据库配置...',0);
        static::PluginDeleteDBConfig($pluginid);
        static::showMsg('完成',1,'success');
        static::PluginDeleteStaticVar($pluginid);
        static::showMsg('卸载完成!',1,'success');
        $data = array("status"=>static::STATUS_SUCCESS,'msg'=>'卸载完成');
        return $data;
    }

    /**
     * 删除插件
     * @param $pluginid string
     */
    static public function delete($pluginid)
    {
        static::showMsg('开始删除插件...');
        try{
            $pluginDir = static::GetPluginPath($pluginid);
            FileHelper::removeDirectory($pluginDir);
            static::showMsg('删除完成',1,'success');
            return ['status'=>static::STATUS_SUCCESS,'msg'=>'删除成功'];
        }catch(ErrorException $e){
            static::showMsg('删除失败(没有权限)，请手动删除插件相关文件和目录！',1,'error');
            static::showMsg($e->getMessage(),1,'error');
            return ['status' => static::STATUS_ERROR,'msg' => "删除失败(没有权限)，请手动删除插件相关文件和目录！"];
        }
    }

}
