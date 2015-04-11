<?php 
$controller = Yii::app()->controller->id;
$action = Yii::app()->controller->action->id;
?>
<div class="toolbar-action">
	<div class="ta-inner div-table">
		<div class="div-row">
			<div class="div-column-r">
				<?php if(empty($this->btnOptions)):?>
					<?php 
					$action = Yii::app()->controller->action->id;
					?>
					<?php if($action=='admin'):?>
					<a class="btn btn-success btn-sm" href="<?php echo $this->createUrl('create')?>"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;<?php echo Yii::t('main','Create New')?></a>
					<a class="btn btn-primary btn-sm search-button" href="<?php echo $this->createUrl('create')?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>&nbsp;<?php echo Yii::t('main','Search')?></a>
					<a class="btn btn-danger btn-sm" href="javascript: void(0);" onclick="return CoreJs.deleteAll('<?php echo $this->createUrl('delMulti')?>');"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbsp;<?php echo Yii::t('main','Delete')?></a>
					<?php elseif(in_array($action, array('create','update'))):?>
					<a class="btn btn-primary btn-sm submit" href="#"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;<?php echo Yii::t('main','Save')?></a>
					<a class="btn btn-primary btn-sm apply" href="#"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>&nbsp;<?php echo Yii::t('main','Save & Continue')?></a>
					<a class="btn btn-warning btn-sm" href="<?php echo $this->createUrl('admin')?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbsp;<?php echo Yii::t('main','Close')?></a>
					<?php elseif(in_array($action, array('view'))):?>
					<a class="btn btn-primary btn-sm submit" href="<?php echo $this->createUrl('update', array('id'=>$_GET['id']))?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;<?php echo Yii::t('main','Update')?></a>
					<a class="btn btn-warning btn-sm" href="<?php echo $this->createUrl('admin')?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbsp;<?php echo Yii::t('main','Close')?></a>
					<?php endif;?>
				<?php else:?>
					<?php echo $this->btnOptions; ?>
				<?php endif;?>
			</div>
		</div>
		<?php echo $this->clips['toolbar-ac'];?>
	</div>
</div>
<script>
jQuery(function(){
	$(".submit").live("click", function(){
		$("form").submit();
	})
	$(".apply").live("click", function(){
		$("#apply").attr("value",1);
		$("form").submit();
	})
})
</script>