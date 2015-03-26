<?php
/**
 * PluginBaseController
 * 所有的插件都要继承此controller
 * @author xiongchuan <xiongchuan@luxtonenet.com>
 */
namespace app\modules\plugin\components;
use app\common\Controller;
use yii;
class PluginBaseController extends Controller
{
	protected $pluginName = "";
	
	public $layout = '/column2';
	
	public function init()
	{
		parent::init();
		$this->getPluginName();
	}
	
	public function getViewPath()
	{
		return $this->module->getViewPath();
	}
	
	/**
	 * 通过类名获取插件的名字
	 */
	public function getPluginName()
	{
		$className = get_called_class();
		$this->pluginName = str_replace("Controller", "", $className);
	}
}
