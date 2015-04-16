<?php
$this->breadcrumbs=array(
	'Admin Genre Models'=>array('index'),
	$model->name=>array('view','id'=>$model->_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AdminGenreModel', 'url'=>array('index')),
	array('label'=>'Create AdminGenreModel', 'url'=>array('create')),
	array('label'=>'View AdminGenreModel', 'url'=>array('view', 'id'=>$model->_id)),
	array('label'=>'Manage AdminGenreModel', 'url'=>array('admin')),
);
?>

<h1>Update Genre {<?php echo $model->name; ?>}</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>