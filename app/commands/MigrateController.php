<?php

namespace app\commands;

use yii\base\InvalidConfigException;
use yii\console\controllers\MigrateController as BaseMigrateController;
use yii;
use app\models\PluginManager;
/**
 * Class MigrateController
 *
 * @package yii2mod\rbac\commands
 *
 * Below are some common usages of this command:
 *
 * ```
 * # creates a new migration named 'create_rule'
 * yii rbac/migrate/create create_rule
 *
 * # applies ALL new migrations
 * yii rbac/migrate
 *
 * # reverts the last applied migration
 * yii rbac/migrate/down
 * ```
 */
class MigrateController extends BaseMigrateController
{
    /**
     * @inheritdoc
     */
    public $migrationTable = '{{%migration}}';

    /**
     * @var string 默认路径
     */
    public $defaultMigrationPath = '@app/migrations';

    /**
     * @inheritdoc
     */
    public $migrationPath = '';

    /**
     * @inheritdoc
     */
    public $templateFile = '@vendor/yii2mod/yii2-rbac/views/migration.php';

    protected $_plugin_migration_paths = [];

    public function init()
    {

        parent::init();
    }

    /**
     * 如果 migrationPath 有值,则说明yii migrate --migrationPath=$path,通过传参运行
     * migrationPath 没有传参,则使用默认的 defaultMigrationPath 和 plugin的migrations
     *
     * 此method需要放在beforeAction里面,此时migrationPath已经被赋值。
     */
    public function generateMigrationPath()
    {
        //
        if($this->migrationPath != ''){
            $path = Yii::getAlias($this->migrationPath);
            if(is_dir($path)){
                $this->_plugin_migration_paths[] = $path;
            }else{
                //报错,退出
                throw new InvalidConfigException("Migration failed. Directory specified in migrationPath doesn't exist: {$this->migrationPath}");
            }

        }else{
            //如果system config被migrate/down 删除了,会报错,通过try catch 过滤掉
            try {
                //自动把插件的migrations path加入到搜索路径
                $setupedPlugins = PluginManager::GetSetupedPlugins();
                if ($setupedPlugins && is_array($setupedPlugins)) foreach ($setupedPlugins as $plugin) {
                    $pluginId = isset($plugin['id']) ? $plugin['id'] : '';
                    $path = Yii::getAlias('@plugins') . DIRECTORY_SEPARATOR . "{$pluginId}" . DIRECTORY_SEPARATOR . "migrations";
                    if (is_dir($path)) {
                        $this->_plugin_migration_paths[] = $path;
                    }
                }
            }catch (yii\base\Exception $e){
                //不影响
            }
            $this->migrationPath = $this->defaultMigrationPath;//如果不赋值,basemigratecontroller会报错
            //默认的migrationPath
            $path = Yii::getAlias($this->migrationPath);
            if(is_dir($path)){
                $this->_plugin_migration_paths[] = $path;
            }
        }
        //添加path到include path
        if(count($this->_plugin_migration_paths)>0){
            $need_include_paths = join(PATH_SEPARATOR,$this->_plugin_migration_paths);
            set_include_path(get_include_path() . PATH_SEPARATOR . $need_include_paths);
        }else{
            throw new InvalidConfigException('At least one of `defaultMigrationPath` or `migrationPath` or `migrationNamespaces` should be specified.');
        }
    }

    public function beforeAction($action){

        $this->generateMigrationPath();

        return parent::beforeAction($action);
    }

    //重构
    protected function createMigration($class)
    {
        $class = trim($class, '\\');
        if (strpos($class, '\\') === false) {
            $file = $class . '.php';
            require_once($file);
        }

        return new $class();
    }

    //重构
    protected function getNewMigrations()
    {
        $applied = [];
        foreach ($this->getMigrationHistory(null) as $class => $time) {
            $applied[trim($class, '\\')] = true;
        }

        $migrationPaths = [];
        //把plugins的加进来
        foreach ($this->_plugin_migration_paths as $_path){
            $migrationPaths[] = $_path;
        }
        //已经包含过了
//        if (!empty($this->migrationPath)) {
//            $migrationPaths[''] = $this->migrationPath;
//        }
        foreach ($this->migrationNamespaces as $namespace) {
            $migrationPaths[$namespace] = $this->getNamespacePath($namespace);
        }


        $migrations = [];
        foreach ($migrationPaths as $namespace => $migrationPath) {
            if (!file_exists($migrationPath)) {
                continue;
            }
            $handle = opendir($migrationPath);
            while (($file = readdir($handle)) !== false) {
                if ($file === '.' || $file === '..') {
                    continue;
                }
                $path = $migrationPath . DIRECTORY_SEPARATOR . $file;
                if (preg_match('/^(m(\d{6}_?\d{6})\D.*?)\.php$/is', $file, $matches) && is_file($path)) {
                    $class = $matches[1];
                    //增加判断,如果namespace是数字,代表添加的全局的plugin的migrations
                    if (!empty($namespace) && !is_numeric($namespace)) {
                        $class = $namespace . '\\' . $class;
                    }
                    $time = str_replace('_', '', $matches[2]);
                    if (!isset($applied[$class])) {
                        $migrations[$time . '\\' . $class] = $class;
                    }
                }
            }
            closedir($handle);
        }
        ksort($migrations);

        return array_values($migrations);
    }
}
