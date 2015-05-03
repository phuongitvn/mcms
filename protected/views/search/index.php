<div class="nar-title"><h1>Results for keyword "<?php echo $keyword;?>"</h1></div>
<?php if(empty($data)){?>
    <p>There doesn't seem to be anything here!</p>
<?php }else{?>
    <?php $this->widget('application.widgets.article.ListViewWidget', array('data'=>$data));?>
        <div class="paging">
            <?php
            $this->widget('application.widgets.Mpagination',
                array(
                    'pages' => $pager,
                    'maxButtonCount'=>$itemOnPaging,
                ));
            ?>
        </div>
<?php }?>
<?php $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'column2')); ?>
<?php $this->widget('application.widgets.article.ListViewWidget', array('data'=>$data, 'title'=>'Most Popular','info_extra'=>false));?>

<?php $this->endWidget();?>