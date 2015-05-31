<?php
    $link = Yii::app()->createUrl('/post/view', array('id'=>$article->_id,'url_key'=>Common::makeFriendlyUrl($article->title)));
    $image = FeedModel::model()->getAvatarUrl($article->thumb);
?>
<div class="post">
	<div class="title">
		<h1><?php echo CHtml::encode($article->title); ?></h1>
	</div>
	<!--<div class="author">
		posted by <?php /*echo $article->created_by; */?>
	</div>-->
	<div class="content">
		<?php
			echo $article->fulltext;
		?>
	</div>
	<!--<div class="nav">
		<b>Tags:</b>
		<?php /*echo $article->tags; */?>
		<br/>
		<?php /*echo CHtml::link('Permalink', $link); */?> |
		<?php /*echo CHtml::link("Comments ({$article->comments})",$link.'#comments'); */?> |
		Last updated on <?php /*echo $article->updated_datetime; */?>
	</div>-->
</div>
