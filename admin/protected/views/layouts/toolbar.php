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
					<?php if(in_array($action, array('admin','create','update','view'))):?>
                        <a class="btn btn-info btn-sm" href="<?php echo $this->createUrl('admin')?>"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>&nbsp;<?php echo Yii::t('main','List')?></a>
					<a class="btn btn-success btn-sm" href="<?php echo $this->createUrl('create')?>"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;<?php echo Yii::t('main','Create New')?></a>
					<a class="btn btn-primary btn-sm search-button" href="<?php echo $this->createUrl('create')?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>&nbsp;<?php echo Yii::t('main','Search')?></a>
					<a class="btn btn-danger btn-sm" href="javascript: void(0);" onclick="return CoreJs.deleteAll('<?php echo $this->createUrl('delMulti')?>');"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbsp;<?php echo Yii::t('main','Delete')?></a>
					<?php endif;?>
				<?php else:?>
					<?php echo $this->btnOptions; ?>
				<?php endif;?>
			</div>
		</div>
		<?php echo $this->clips['toolbar-ac'];?>
	</div>
</div>