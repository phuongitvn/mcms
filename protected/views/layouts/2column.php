<?php
$controller = Yii::app()->controller->id;
$action = Yii::app()->controller->action->id;
?>
<?php $this->beginContent('//layouts/main'); ?>
    <div id="wrr-main">
        <header>
            <div class="wrr-header  wrr-s">
                <div id="logo">
                    <h1><a href="/"><img style="margin-top: 10px" width="155" src="/images/logo.png" /></a></h1>
                </div>
                <div id="menu">
                    <div class="wr-menu">
                        <ul>
                            <li><a href="/" <?php if($controller=='site' && $action=='index'){?>class="active"<?php }?>>Hot</a></li>
                            <li><a href="http://fan2clip.com/" target="_blank">Movie & TV</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <div id="main-body">
            <div class="wrap-inner container wrr-s">
                <div class="wrr-page-content">
                    <div class="col-66 col-f">
                        <div class="wr-col-c">
                            <?php echo $content; ?>
                        </div>
                    </div>
                    <div class="col-33 col-hide">
                        <div class="wr-col-r"><?php echo $this->clips['sidebar-r'];?></div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div><!-- content -->
<?php $this->endContent(); ?>