<?php if($data):?>
    <div class="listview _vertical <?php echo $this->layout;?>">
        <ul class="items-listview">
            <?php foreach($data as $item):?>
                <?php
                $link = Yii::app()->createUrl('/post/view', array('id'=>$item->_id,'url_key'=>Common::makeFriendlyUrl($item->title)));
                $image = FeedModel::model()->getAvatarUrl($item->thumb);
                ?>
                <li class="item">
                    <div>
                        <div class="vil-thumb">
                            <div class="wrr-thumb">
                                <a href="<?php echo $link;?>"><img width="100%" alt="<?php echo $item->title;?>" width="100%" src="<?php echo $image;?>" /></a>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
<?php endif;?>
