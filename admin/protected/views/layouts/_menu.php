<?php 
$module = isset(Yii::app()->controller->module)?Yii::app()->controller->module->id:'';
$controller = Yii::app()->controller->getId();
?>
<ul class="menu-top-level">
	<li class="menu-section">
		<div class="menu-section-item">
		<ul class="apps-link">
			<li><a class="yt-valign" href="<?php echo Yii::app()->createUrl('/');?>"><i class="glyphicon glyphicon-home"></i>&nbsp;<?php echo Yii::t('main','Dashboard')?></a></li>
			<li><a class="yt-valign <?php if($module =='articles' && $controller=='manager') echo 'actived';?>" href="<?php echo Yii::app()->createUrl('/articles/manager/admin');?>"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;<?php echo Yii::t('main','Articles Manager')?></a></li>
			<li><a class="yt-valign <?php if($module =='genre' && $controller=='manager') echo 'actived';?>" href="<?php echo Yii::app()->createUrl('/genre/manager/admin');?>"><i class="glyphicon glyphicon-book icon-blue"></i>&nbsp;<?php echo Yii::t('main','Genre Manager')?></a></li>
			<li><a class="yt-valign <?php if($module=='media') echo 'actived';?>" href="<?php echo Yii::app()->createUrl('/media/manage');?>"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;<?php echo Yii::t('main','Media Manager')?></a></li>
			<li><a class="yt-valign <?php if($module=='polls') echo 'actived';?>" href="<?php echo Yii::app()->createUrl('/polls/poll/admin');?>"><i class="glyphicon glyphicon-tasks"></i>&nbsp;<?php echo Yii::t('main','Polls Manager')?></a></li>
			<li><a class="yt-valign <?php if($module=='menu') echo 'actived';?>" href="<?php echo Yii::app()->createUrl('/menu/menus/admin');?>"><i class="glyphicon glyphicon-align-justify"></i>&nbsp;<?php echo Yii::t('main','Menus Manager')?></a></li>
			<li><a class="yt-valign <?php if($module=='gallery') echo 'actived';?>" href="<?php echo Yii::app()->createUrl('/gallery/galleryItems/admin');?>"><i class="glyphicon glyphicon-picture"></i>&nbsp;<?php echo Yii::t('main','Gallery Manager')?></a></li>
			<li><a class="yt-valign <?php if($module=='blog' && $controller=='post') echo 'actived';?>" href="<?php echo Yii::app()->createUrl('/blog/post/admin');?>"><i class="glyphicon glyphicon-pencil"></i>&nbsp;<?php echo Yii::t('main','Blog Manager')?></a>
				<?php if($module =='blog' ){?>
				<ul class="sub-menu">
					<li><a class="yt-valign <?php if($module =='blog' && $controller=='topic') echo 'actived';?>" href="<?php echo Yii::app()->createUrl('/blog/topic/admin');?>">+&nbsp;<?php echo Yii::t('main','Topic Manager')?></a></li>
				</ul>
				<?php }?>
			</li>
			<li><a class="yt-valign <?php if($module=='comment') echo 'actived';?>" href="<?php echo Yii::app()->createUrl('/comment/manage/admin');?>"><i class="glyphicon glyphicon-comment"></i>&nbsp;<?php echo Yii::t('main','Comment Manager')?></a></li>
			<li><a class="yt-valign <?php if($module=='widget') echo 'actived';?>" href="<?php echo Yii::app()->createUrl('/widget/manage/admin');?>"><i class="glyphicon glyphicon-th-large"></i>&nbsp;Wigets Manager</a></li>
			<li><a class="yt-valign <?php if($module=='translate') echo 'actived';?>" href="<?php echo Yii::app()->createUrl('/translate/filterTranslate/Filterlayout');?>"><i class="glyphicon glyphicon-globe"></i>&nbsp;<?php echo Yii::t('main','Languages Translate')?></a></li>
			<li><a class="yt-valign <?php if($module=='settings' && $controller=='default') echo 'actived';?>" href="<?php echo Yii::app()->createUrl('/settings');?>"><i class="glyphicon glyphicon-cog"></i>&nbsp;<?php echo Yii::t('main','Settings')?></a>
				<?php if($module=='settings'){?>
				<ul class="sub-menu">
					<li><a class="yt-valign <?php if($module =='settings' && $controller=='system') echo 'actived';?>" href="<?php echo Yii::app()->createUrl('/settings/system');?>"><?php echo Yii::t('main','General Setting')?></a></li>
				</ul>
				<?php }?>
			</li>
		</ul>
		</div>
	</li>
</ul>