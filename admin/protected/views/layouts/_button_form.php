<a class="btn btn-primary btn-sm submit" href="#"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;<?php echo Yii::t('main','Save')?></a>
<a class="btn btn-primary btn-sm apply" href="#"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>&nbsp;<?php echo Yii::t('main','Save & Continue')?></a>
<a class="btn btn-warning btn-sm" href="<?php echo $this->createUrl('admin')?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbsp;<?php echo Yii::t('main','Close')?></a>
<script>
    jQuery(function(){
        $(".submit").live("click", function(){
            $("form").submit();
        })
        $(".apply").live("click", function(){
            $("#apply").attr("value",1);
            $("form").submit();
        })
    })
</script>