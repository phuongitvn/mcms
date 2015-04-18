<?php $this->beginContent('//layouts/main'); ?>
    <div id="main-body">
        <div class="wrap-inner container wrr-s">
            <div class="wrr-page-content">
                <div class="column1 col-66 col-f">
                    <div class="wr-col-c">
                        <?php echo $content; ?>
                    </div>
                </div>
                <div class="column2 col-34">
                    <div class="wr-col-r">
                        <?php echo $this->clips['column2'];?>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
<?php $this->endContent(); ?>