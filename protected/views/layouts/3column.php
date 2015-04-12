<?php
$controller = Yii::app()->controller->id;
$action = Yii::app()->controller->action->id;
?>
<?php $this->beginContent('//layouts/main'); ?>
    <div id="wrr-main">
        <header>
            <div id="banner-top">
                <div class="wrr-banner-top wrr-s">
                    <div id="logo">
                        <h1><a href="/"><img style="margin-top: 10px" width="155" src="/images/logo.png" /></a></h1>
                    </div>
                </div>
            </div>
            <div id="menu">
                <div class="wr-menu wrr-s">
                    <ul>
                        <li><a href="/" <?php if($controller=='site' && $action=='index'){?>class="active"<?php }?>>News</a></li>
                        <li><a href="http://fan2clip.com/" target="_blank">Life</a></li>
                        <li><a href="http://fan2clip.com/" target="_blank">Internet</a></li>
                        <li><a href="http://fan2clip.com/" target="_blank">Travel</a></li>
                        <li><a href="http://fan2clip.com/" target="_blank">Health</a></li>
                        <li><a href="http://fan2clip.com/" target="_blank">Sports</a></li>
                        <li><a href="http://fan2clip.com/" target="_blank">More</a></li>
                    </ul>
                </div>
            </div>
        </header>
        <div id="main-body">
            <div class="wrap-inner container wrr-s">
                <div class="wrr-page-content">
                    <div class="column1 col-50 col-f">
                        <div class="wr-col-c">
                            <?php echo $content; ?>
                        </div>
                    </div>
                    <div class="column2 col-34">
                        <div class="wr-col-r">
                            <?php echo $this->clips['column2'];?>
                        </div>
                    </div>
                    <div class="column3 col-16 col-hide">
                        <div class="wr-col-r"><?php echo $this->clips['column3'];?></div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div><!-- content -->
<?php $this->endContent(); ?>