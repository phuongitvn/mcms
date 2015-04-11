<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<div class="lastUnit size1of1 header">
<h1><?php echo '<?php'; ?> echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>
</div>
<div class="o-act-tbar">
<a class="add-btn button p0" href="<?php echo '<?php'; ?> echo $this->createUrl('create');?>"><?php echo '<?php';?> echo Yii::t('main', 'Create');?></a>
<a class="add-btn button p0" href="<?php echo '<?php'; ?> echo $this->createUrl('update', array('id' => $model-><?php echo $this->tableSchema->primaryKey; ?>));?>"><?php echo '<?php';?> echo Yii::t('main', 'Update');?></a>
<a class="add-btn button p0" href="<?php echo '<?php'; ?> echo $this->createUrl('delete', array('id' => $model-><?php echo $this->tableSchema->primaryKey; ?>));?>" onclick="return confirm('Are you sure you want to delete this item?');"><?php echo '<?php';?> echo Yii::t('main', 'Delete');?></a>
</div>
<?php echo '<?php'; ?> $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
<?php
foreach ($this->tableSchema->columns as $column)
		echo $this->generateDetailViewAttribute($this->modelClass, $column) . ",\n";
?>
	),
)); ?>

<?php foreach (GxActiveRecord::model($this->modelClass)->relations() as $relationName => $relation): ?>
<?php if ($relation[0] == GxActiveRecord::HAS_MANY || $relation[0] == GxActiveRecord::MANY_MANY): ?>
<h2><?php echo '<?php'; ?> echo GxHtml::encode($model->getRelationLabel('<?php echo $relationName; ?>')); ?></h2>
<?php echo "<?php\n"; ?>
	echo GxHtml::openTag('ul');
	foreach($model-><?php echo $relationName; ?> as $relatedModel) {
		echo GxHtml::openTag('li');
		echo GxHtml::link(GxHtml::encode(GxHtml::valueEx($relatedModel)), array('<?php echo strtolower($relation[1][0]) . substr($relation[1], 1); ?>/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true)));
		echo GxHtml::closeTag('li');
	}
	echo GxHtml::closeTag('ul');
<?php echo '?>'; ?>
<?php endif; ?>
<?php endforeach; ?>