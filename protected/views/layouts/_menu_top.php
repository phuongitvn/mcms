<?php
$controller = Yii::app()->controller->id;
$action = Yii::app()->controller->action->id;
$url_key = Yii::app()->request->getParam('url_key','');
?>
<div id="menu">
    <div class="wr-menu wrr-s">
        <ul class="main-nv">
            <li><a class="<?php if($controller=='site' && $action=='index'){?>active<?php }?>" href="/">Home</a></li>
            <li class="separator"></li>
            <li><a href="<?php echo Yii::app()->createUrl('/category/index', array('url_key'=>'news'))?>" class="<?php if($controller=='category' && $action=='index' && $url_key=='news'){?>active<?php }?>">News</a></li>
            <li class="separator"></li>
            <li class="dropdown"><a class="<?php if($controller=='category' && $action=='index' && $url_key=='health'){?>active<?php }?>" href="<?php echo Yii::app()->createUrl('/category/index', array('url_key'=>'health'))?>">Health</a>
                <!--<ul class="drop-nav">
                    <li><a href="#">Beauty Care</a></li>
                    <li><a href="#">Food</a></li>
                    <li><a href="#">Love and Sex</a></li>
                    <!--<li class="flyout">
                        <a href="#">Photography</a>
                        <ul class="flyout-nav">
                            <li><a href="#">Nature</a></li>
                            <li><a href="#">People</a></li>
                            <li><a href="#">Pets</a></li>
                        </ul>
                    </li>
                </ul>-->
            </li>
            <li class="separator"></li>
            <li class="dropdown"><a class="<?php if($controller=='category' && $action=='index' && $url_key=='beauty'){?>active<?php }?>" href="<?php echo Yii::app()->createUrl('/category/index', array('url_key'=>'beauty'))?>">Beauty Care</a></li>
            <li class="separator"></li>
            <li class="dropdown">
                <a class="<?php if($controller=='category' && $action=='index' && $url_key=='food-fitness'){?>active<?php }?>" href="<?php echo Yii::app()->createUrl('/category/index', array('url_key'=>'food-fitness'))?>" >Food & Fitness</a>
            </li>
            <li class="separator"></li>
            <li class="dropdown">
                <a class="<?php if($controller=='category' && $action=='index' && $url_key=='work-play'){?>active<?php }?>" href="<?php echo Yii::app()->createUrl('/category/index', array('url_key'=>'tech'))?>" >Work & Play</a>
            </li>
            <li class="separator"></li>
            <li class="dropdown">
                <a href="<?php echo Yii::app()->createUrl('/category/index', array('url_key'=>'social-media'))?>">How To</a>
            </li>
            <li style="float: right;margin-right: 10px;">
                <div class="search">
                    <form action="<?php echo Yii::app()->createUrl('/search/index')?>" method="get">
                        <input type="text" name="keyword" placeholder="Search" value="<?php echo isset($_GET['keyword'])?CHtml::encode($_GET['keyword']):"";?>" />
                        <button type="submit">Search</button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>