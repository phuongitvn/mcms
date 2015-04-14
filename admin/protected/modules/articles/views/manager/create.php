<?php
$this->breadcrumbs=array(
	'Admin Articles Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AdminArticlesModel', 'url'=>array('index')),
	array('label'=>'Manage AdminArticlesModel', 'url'=>array('admin')),
);
?>

<h1>Create AdminArticlesModel</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>