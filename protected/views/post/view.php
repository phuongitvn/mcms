<?php
$this->pageTitle=$article->title;
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
