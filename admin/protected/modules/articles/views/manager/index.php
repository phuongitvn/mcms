<?php
$this->breadcrumbs=array(
	'Admin Articles Models',
);

$this->menu=array(
	array('label'=>'Create AdminArticlesModel', 'url'=>array('create')),
	array('label'=>'Manage AdminArticlesModel', 'url'=>array('admin')),
);
?>

<h1>Admin Articles Models</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>