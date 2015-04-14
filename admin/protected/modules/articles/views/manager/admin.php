<?php
$this->breadcrumbs=array(
	'Admin Articles Models'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List AdminArticlesModel', 'url'=>array('index')),
	array('label'=>'Create AdminArticlesModel', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-articles-model-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

?>

<h1>Manage Admin Articles Models</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('application.widgets.iGridView', array(
	'id'=>'admin-articles-model-grid',
	'dataProvider'=>new EMongoDocumentDataProvider($model->search(), array(
		'sort'=>array(
			'attributes'=>array(
				'_id',
				'title',
				//'introtext',
				//'fulltext',
				'genre',
				'tags',
				/*
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
				*/
			),
		),
	)),
	'filter'=>$model,
	'columns'=>array(
		'_id',
		'title',
		//'introtext',
		//'fulltext',
		'genre',
		'tags',
		/*
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
		*/
        array(
            'class'=>'application.widgets.iButtonColumn',
            'htmlOptions'=>array('style'=>'width: 50px'),
        ),
	),
)); ?>