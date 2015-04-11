<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<div class="lastUnit size1of1 header">
<h1><?php echo '<?php'; ?> echo Yii::t('main', 'Update') . ' ' . GxHtml::encode($model->label()) . ' ' . GxHtml::encode(GxHtml::valueEx($model)); ?></h1>
</div>
<div class="o-act-tbar">
<a class="add-btn button p0" href="<?php echo '<?php'; ?> echo $this->createUrl('create');?>"><?php echo '<?php';?> echo Yii::t('main', 'Create');?></a>&nbsp;
<a class="add-btn button p0" href="<?php echo '<?php'; ?> echo $this->createUrl('view', array('id' => GxActiveRecord::extractPkValue($model, true)));?>"><?php echo '<?php';?> echo Yii::t('main', 'View');?></a>
</div>
<?php echo "<?php\n"; ?>
$this->renderPartial('_form', array(
		'model' => $model));
?>