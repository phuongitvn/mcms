<?php
$this->breadcrumbs=array(
	'Admin Genre Models'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List AdminGenreModel', 'url'=>array('index')),
	array('label'=>'Create AdminGenreModel', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-genre-model-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

?>

<h1>Manage Genre</h1>


<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('application.widgets.iGridView', array(
	'id'=>'admin-genre-model-grid',
	'dataProvider'=>new EMongoDocumentDataProvider($model->search(), array(
	)),
	'filter'=>$model,
	'columns'=>array(
        array(
            'type'	=>	'raw',
            'header'	=>'<div id="sl-row" onclick="CoreJs.checkAll(this.id);" status="1"><input type="checkbox" class="checkall" value="" /></div>',
            'value'	=>	'CHtml::checkBox("rad_ID[]", "", array("value"=>$data->_id))',
            'htmlOptions'	=>	array(
                'width'	=>	'50',
            ),
        ),
        array(
            'name'=>'name',
            'type'=>'raw',
            'value'=>'CHtml::link($data->name,array("update","id"=>$data->_id))'
        ),
		'code',
		'description',
		'parent',
        '_id',
		/*
		'updated_datetime',
		'position',
		'created_by',
		'status',
		*/
        array(
            'class'=>'application.widgets.iButtonColumn',
            'htmlOptions'=>array('style'=>'width: 50px'),
        ),
	),
)); ?>