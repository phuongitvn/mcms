<?php
$this->pageTitle=$article->title;
$this->breadcrumbs=array(
    $article->genre=>Yii::app()->createUrl('/category/index', array('url_key'=>Common::makeFriendlyUrl($article->genre))),
    $article->title,
);
?>

<?php $this->renderPartial('_view', array(
	'article'=>$article,
)); ?>

<div id="comments">
	<?php if($article->comments>=1): ?>
		<h3>
			<?php echo $article->comments>1 ? $article->comments . ' comments' : 'One comment'; ?>
		</h3>

		<?php $this->renderPartial('_comments',array(
			'post'=>$article,
			'comments'=>$article->comments,
		)); ?>
	<?php endif; ?>

	<h3>Leave a Comment</h3>

	<?php if(Yii::app()->user->hasFlash('commentSubmitted')): ?>
		<div class="flash-success">
			<?php echo Yii::app()->user->getFlash('commentSubmitted'); ?>
		</div>
	<?php else: ?>
		<?php /*$this->renderPartial('/comment/_form',array(
			'model'=>$comment,
		));*/ ?>
	<?php endif; ?>

</div><!-- comments -->

<?php $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'column2')); ?>
<?php $this->widget('application.widgets.article.ListViewWidget', array('data'=>$data, 'title'=>'You may also like','info_extra'=>false));?>
<?php $this->endWidget();?>