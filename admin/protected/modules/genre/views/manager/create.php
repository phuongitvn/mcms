<?php
$this->breadcrumbs=array(
	'Admin Genre Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AdminGenreModel', 'url'=>array('index')),
	array('label'=>'Manage AdminGenreModel', 'url'=>array('admin')),
);
?>

<h1>Create AdminGenreModel</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>