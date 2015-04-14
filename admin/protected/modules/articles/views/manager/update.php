<?php
$this->breadcrumbs=array(
	'Admin Articles Models'=>array('index'),
	$model->title=>array('view','id'=>$model->_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AdminArticlesModel', 'url'=>array('index')),
	array('label'=>'Create AdminArticlesModel', 'url'=>array('create')),
	array('label'=>'View AdminArticlesModel', 'url'=>array('view', 'id'=>$model->_id)),
	array('label'=>'Manage AdminArticlesModel', 'url'=>array('admin')),
);
?>

<h1>Update AdminArticlesModel <?php echo $model->_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>