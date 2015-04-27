<?php
$this->breadcrumbs=array(
	'Admin Genre Models'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List AdminGenreModel', 'url'=>array('index')),
	array('label'=>'Create AdminGenreModel', 'url'=>array('create')),
	array('label'=>'Update AdminGenreModel', 'url'=>array('update', 'id'=>$model->_id)),
	array('label'=>'Delete AdminGenreModel', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AdminGenreModel', 'url'=>array('admin')),
);
?>

<h1>View AdminGenreModel #<?php echo $model->_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'_id',
		'name',
		'code',
		'url_key',
		'description',
		'parent',
		'created_datetime',
		'updated_datetime',
		'position',
		'created_by',
		'status',
	),
)); ?>