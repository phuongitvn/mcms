<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<div class="lastUnit size1of1 header">
<h1><?php echo '<?php'; ?> echo Yii::t('app', 'Create') . ' ' . GxHtml::encode($model->label()); ?></h1>
</div>
<?php echo "<?php\n"; ?>
$this->renderPartial('_form', array(
		'model' => $model,
		'buttons' => 'create'));
<?php echo '?>'; ?>