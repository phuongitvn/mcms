<?php
$this->widget('application.widgets.article.ListViewWidget', array('data'=>$data));
?>
<?php $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'column2')); ?>
    <?php $this->widget('application.widgets.article.ListViewWidget', array('data'=>$data, 'layout'=>'_vertical','title'=>'Featured'));?>
<?php $this->endWidget();?>

<?php $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'column3')); ?>
    <?php $this->widget('application.widgets.article.ListViewWidget', array('data'=>$data, 'layout'=>'_image'));?>
<?php $this->endWidget();?>