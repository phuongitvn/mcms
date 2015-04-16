<?php
$this->breadcrumbs=array(
	'Admin Articles Models'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List AdminArticlesModel', 'url'=>array('index')),
	array('label'=>'Create AdminArticlesModel', 'url'=>array('create')),
	array('label'=>'Update AdminArticlesModel', 'url'=>array('update', 'id'=>$model->_id)),
	array('label'=>'Delete AdminArticlesModel', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AdminArticlesModel', 'url'=>array('admin')),
);
?>

<h1>View #<?php echo $model->_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'_id',
		'title',
		'introtext',
		'fulltext',
		'genre',
		'tags',
		'views',
		'thumb',
		'comments',
		'url_source',
		'source',
		'created_datetime',
		'updated_datetime',
		'active_datetime',
		'created_by',
		'status',
	),
)); ?>