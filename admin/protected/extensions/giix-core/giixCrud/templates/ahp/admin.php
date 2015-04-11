<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php
echo "<?php\n";
?>

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="lastUnit size1of1 header">
<h1><?php echo '<?php'; ?> echo Yii::t('app', 'Manage') . ' ' . GxHtml::encode($model->label(2)); ?></h1>
</div>
<div class="o-act-tbar">
<a class="add-btn button p0" href="<?php echo '<?php'; ?> echo $this->createUrl('create');?>"><?php echo '<?php';?> echo Yii::t('main', 'Create');?></a>
</div>
<?php echo "<?php echo GxHtml::link(Yii::t('app', 'Advanced Search'), '#', array('class' => 'search-button')); ?>"; ?>

<div class="search-form">
<?php echo "<?php \$this->renderPartial('_search', array(
	'model' => \$model,
)); ?>\n"; ?>
</div><!-- search-form -->

<?php echo '<?php'; ?> $this->widget('baseGridView', array(
	'id' => '<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
<?php
$count = 0;
foreach ($this->tableSchema->columns as $column) {
	if (++$count == 7)
		echo "\t\t/*\n";
	echo "\t\t" . $this->generateGridViewColumn($this->modelClass, $column).",\n";
}
if ($count >= 7)
	echo "\t\t*/\n";
?>
		array(
			'class' => 'CButtonColumn',
		),
	),
)); ?>