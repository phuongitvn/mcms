<?php 
$controller = Yii::app()->controller->id;
$action = Yii::app()->controller->action->id;
?>
<div class="toolbar-action" style="float: right">
        <?php if(empty($this->btnOptions)):?>
            <?php if(in_array($action, array('admin','create','update','view'))):?>
                <a class="btn btn-info btn-sm" href="<?php echo $this->createUrl('admin')?>"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>&nbsp;<?php echo Yii::t('main','List')?></a>
                <a class="btn btn-info btn-sm" href="<?php echo $this->createUrl('create')?>"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;<?php echo Yii::t('main','Create New')?></a>
                    <?php if(in_array($action, array('view'))):?>
                    <a class="btn btn-info btn-sm" href="<?php echo $this->createUrl('update', array('id'=>Yii::app()->request->getParam('id')))?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;<?php echo Yii::t('main','Update')?></a>
                    <?php endif;?>
                <?php if(in_array($action, array('update'))):?>
                    <a class="btn btn-info btn-sm" href="<?php echo $this->createUrl('view', array('id'=>Yii::app()->request->getParam('id')))?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>&nbsp;<?php echo Yii::t('main','View')?></a>
                <?php endif;?>
                <a class="btn btn-info btn-sm search-button" href="<?php echo $this->createUrl('create')?>"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>&nbsp;<?php echo Yii::t('main','Search')?></a>
                <a class="btn btn-danger btn-sm" href="javascript: void(0);" onclick="return CoreJs.deleteAll('<?php echo $this->createUrl('delMulti')?>');"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbsp;<?php echo Yii::t('main','Delete')?></a>
            <?php endif;?>
        <?php else:?>
            <?php echo $this->btnOptions; ?>
        <?php endif;?>
		<?php echo $this->clips['toolbar-ac'];?>
</div>
<br style="clear: both"/>