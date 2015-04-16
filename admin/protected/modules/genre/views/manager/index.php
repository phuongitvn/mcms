<?php
$this->breadcrumbs=array(
	'Admin Genre Models',
);

$this->menu=array(
	array('label'=>'Create AdminGenreModel', 'url'=>array('create')),
	array('label'=>'Manage AdminGenreModel', 'url'=>array('admin')),
);
?>

<h1>Admin Genre Models</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>