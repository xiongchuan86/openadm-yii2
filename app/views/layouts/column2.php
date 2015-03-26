<?php $this->beginContent('@app/views/layouts/main.php');
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
?>

	<div class="row">
		<!-- start: Main Menu -->
		<div id="sidebar-left" class="col-lg-2 col-sm-1 ">
			<div class="sidebar-nav nav-collapse collapse navbar-collapse">
				<ul class="nav main-menu">
					<?php if(Yii::$app->params['MAINMENU'])foreach(Yii::$app->params['MAINMENU'] as $menu):?>
					<li <?php if(is_int(strpos("/".Yii::$app->controller->route,$menu['cfg_value']))):?>class="active"<?php endif;?>><a  <?php if(isset(Yii::$app->params['SUBMENU'][$menu['id']])):?>class="dropmenu"<?php endif;?> href="<?php echo Url::to($menu['cfg_value']);?>"><i class="fa <?php echo isset(Yii::$app->params['ICONS'][$menu['cfg_comment']]) ? Yii::$app->params['ICONS'][$menu['cfg_comment']] : 'fa-ellipsis-h';?>"></i><span class="hidden-sm text"> <?php echo $menu['cfg_comment'];?></span> <?php if(isset(Yii::$app->params['SUBMENU'][$menu['id']])):?><span class="chevron closed"></span><?php endif;?></a>	
					<?php if(isset(Yii::$app->params['SUBMENU'][$menu['id']])):?>
					<ul>
						<?php foreach(Yii::$app->params['SUBMENU'][$menu['id']] as $k1=>$v1):
						//var_dump($k1,$v1,Yii::$app->controller->route,strpos("/".Yii::$app->controller->route,$k1));
							?>
						<li <?php if(is_int(strpos("/".Yii::$app->controller->route,$k1))):?>class="active"<?php endif;?>><a class="submenu" href="<?php echo Url::to($k1);?>"><i class="fa fa-chevron-right"></i><span class="hidden-sm text"> <?php echo $v1;?></span></a></li>
						<?php endforeach;?>
					</ul>
					<?php endif;?>
					</li>
					<?php endforeach;?>
				</ul>
			</div>
			<a href="#" id="main-menu-min" class="full visible-md visible-lg"><i class="fa fa-angle-double-left"></i></a>
        </div>
		<!-- end: Main Menu -->
					
		<!-- start: Content -->
		<div id="content" class="col-lg-10 col-sm-11 ">
			<?php
					echo Breadcrumbs::widget([
						'tag'   => 'ol',
					    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
					]);
				?>
				<?= $content ?>
		</div>
		<!-- end: Content -->
			</div><!--/row-->		

<?php $this->endContent(); ?>