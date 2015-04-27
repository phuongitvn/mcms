<?php
$this->pageTitle = $genre->name;
$this->breadcrumbs=array(
    $genre->name
);
?>
    <h1 class="title"><?php echo CHtml::encode($genre->name);?></h1>
<?php
$this->widget('application.widgets.article.ListViewWidget', array('data'=>$articles));
?>
<?php $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'column2')); ?>
<?php $this->widget('application.widgets.article.ListViewWidget', array('data'=>$articles, 'layout'=>'_vertical','title'=>'Featured'));?>
<?php $this->endWidget();?>