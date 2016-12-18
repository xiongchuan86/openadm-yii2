<?php

namespace app\modules\rbac\components;

use app\common\Controller;
use app\modules\rbac\assets\RbacAsset;
use app\common\SystemConfig;

class RbacBaseController extends Controller
{
	protected $tabs = [];
	public function init()
	{
		parent::init();
		RbacAsset::register($this->view);
		
		//$pid = 5874;
		//$this->tabs = SystemConfig::GetArrayValue("THIRDMENU",$pid,"USER");
	}
}
