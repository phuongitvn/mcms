<?php if($data):?>
    <div class="listview">
        <?php if(!empty($title)){?>
        <h3 class="title"><?php echo $title;?></h3>
        <?php }?>
        <ul class="items-listview">
            <?php foreach($data as $item):?>
                <?php
                $link = Yii::app()->createUrl('/post/view', array('id'=>$item->_id,'url_key_cat1'=>$item->genre,'url_key'=>Common::makeFriendlyUrl($item->title)));
                $image = FeedModel::model()->getAvatarUrl($item->thumb);
                ?>
                <li class="item">
                    <div>
                        <div class="vil-thumb">
                            <div class="wrr-thumb">
                                <a href="<?php echo $link;?>"><img width="125" height="83" alt="<?php echo $item->title;?>" width="100%" src="<?php echo $image;?>" /></a>
                            </div>
                        </div>
                        <div class="vil-info">
                            <h2><a href="<?php echo $link;?>"><?php echo $item->title;?></a></h2>
                            <?php if($this->info_extra):?>
                                <p class="intro"><?php echo $item->introtext;?></p>
                                <ul class="meta-small">
                                    <li><a class="author" href="#"><i class="icon author-icon"></i><?php echo $item->created_by;?>phuong nguyen</a></li>
                                    <li><a class="views" href="#"><i class="icon views-icon"></i><?php echo $item->created_by;?>146</a></li>
                                    <li><a class="comments" href="#"><i class="icon comments-icon"></i><?php echo $item->created_by;?>comments</a></li>
                                    <li><a class="time" href="#"><i class="icon time-icon"></i><?php echo date('l, F jS Y \a\t g:ia', strtotime((string) $item->created_datetime));?></a></li>
                                </ul>
                            <?php endif;?>
                        </div>
                    </div>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
<?php endif;?>
