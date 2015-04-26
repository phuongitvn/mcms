<div class="nar-title"><h1>Results for keyword "<?php echo $keyword;?>"</h1></div>
<?php if(empty($data)){?>
    <p>There doesn't seem to be anything here!</p>
<?php }else{?>
    <?php $this->widget('application.widgets.article.ListViewWidget', array('data'=>$data));?>
    <?php if(count($data)>=$limit){?>
        <div class="pagination"><div class="wr-paging">
                <?php
                $prevLink = ($page>1)?Yii::app()->createUrl('/search/index', array('key'=>$keyword,'page'=>$page-1)):Yii::app()->createUrl('/search/index',array('key'=>$keyword,'page'=>1));
                $nextLink = (count($data)<=$limit)?'#':Yii::app()->createUrl('/search/index', array('key'=>$keyword,'page'=>$page+1));
                ?>
                <a class="btn2 prev" href="<?php echo $prevLink;?>">Prev<span class="icon-arr icon-arr-l"></span></a>
                <a class="btn2 next" href="<?php echo $nextLink;?>">Next<span class="icon-arr icon-arr-r"></span></a>
            </div></div>
    <?php }?>
<?php }?>
<?php $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'column2')); ?>
<?php $this->widget('application.widgets.article.ListViewWidget', array('data'=>$data, 'title'=>'Most Popular','info_extra'=>false));?>

<?php $this->endWidget();?>