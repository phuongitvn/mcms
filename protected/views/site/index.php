<?php
$this->widget('application.widgets.feed.ListViewWidget', array('data'=>$data));
?>
<?php $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'column2')); ?>
    <?php $this->widget('application.widgets.feed.ListViewWidget', array('data'=>$data, 'layout'=>'_vertical'));?>
<?php $this->endWidget();?>

<?php $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'column3')); ?>
    <?php $this->widget('application.widgets.feed.ListViewWidget', array('data'=>$data, 'layout'=>'_image'));?>
<?php $this->endWidget();?>