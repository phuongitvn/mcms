<?php 
$urlActive = $_SERVER['REQUEST_URI'];
$module = Yii::app()->controller->getModule();
if($module){
	$moduleId = $module->id;
}else{
	$moduleId='';
}
?>
<div id="cssmenu" class="primary-nav nomargin navtoggle">
<ul>
   <li><a href='#'>
	   <span class="glyphicon glyphicon-home"></span>
	   <span><?php echo Yii::t('main','Dashboard')?></span></a>
   </li>
   <?php
   		$userActive = ($moduleId=='user')?'active':'';
   ?>
   <li class='has-sub <?php echo $userActive;?>'>
	   <a href='#'>
		   <span class="glyphicon glyphicon-user"></span>
		   <span><?php echo Yii::t('main','Account Manager')?></span>
		   <span class="glyphicon glyphicon-chevron-down chevron-down"></span>
	   </a>
      <?php 
      	$this->widget('zii.widgets.CMenu',array(
      		'items'=>array(
      				array('label'=>Yii::t('main','Create Account'), 'url'=>array('/user/admin/create'), 'visible'=>UserComponent::checkAccessUser('user@AdminCreate')),
      				array('label'=>Yii::t('main','List Account'), 'url'=>array('/user/admin'), 'visible'=>UserComponent::checkAccessUser('user@AdminAdmin')),
      				array('label'=>Yii::t('main','Manage Profile Field'), 'url'=>array('/user/profileField/admin'), 'visible'=>UserComponent::checkAccessUser('user@ProfileFieldAdmin')),
		), 'htmlOptions'=>array('style'=>($userActive=='active')?'display: block':'')));
      ?>
   </li>
   <li class="last">
	   <a href='#'>
		   <span class="glyphicon glyphicon-th"></span>
		   <span>Project Manager</span>
	   </a>
   </li>
   <li class="has-sub <?php echo ($moduleId=='settings')?"active":"";?>">
	   <a href='#'>
		   <span class="glyphicon glyphicon-cog"></span>
		   <span><?php echo Yii::t("main","Settings")?></span>
		   <span class="glyphicon glyphicon-chevron-down chevron-down"></span>
	   </a>
	   <?php 
      	$this->widget('zii.widgets.CMenu',array(
      		'items'=>array(
      				array('label'=>Yii::t('main','Create'), 'url'=>array('/settings/admin/create'), 'visible'=>UserComponent::checkAccessUser('user@AdminCreate')),
      				array('label'=>Yii::t('main','List'), 'url'=>array('/settings/admin/admin'), 'visible'=>UserComponent::checkAccessUser('user@AdminAdmin')),
		), 'htmlOptions'=>array('style'=>($moduleId=='settings')?'display: block':'')));
      ?>
   </li>
</ul>
</div>