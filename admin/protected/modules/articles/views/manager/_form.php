<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'admin-articles-model-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    <?php
         $image = FeedModel::model()->getAvatarUrl($model->thumb);
    $width = Yii::app()->params['profile_image']['thumb']['width'];
    $height = Yii::app()->params['profile_image']['thumb']['height'];
    ?>
    <div class="row">
        <img class="img-thumbnail" width="<?php echo $width;?>" height="<?php echo $height;?>" src="<?php echo $image;?>" id="thumb" />
        <?php $this->widget('ext.EAjaxUpload.EAjaxUpload',
            array(
                'id'=>'uploadFile',
                'config'=>array(
                    'action'=>Yii::app()->createUrl('/site/upload'),
                    'allowedExtensions'=>array("jpg"),//array("jpg","jpeg","gif","exe","mov" and etc...
                    'sizeLimit'=>10*1024*1024,// maximum file size in bytes
                    'minSizeLimit'=>1*1024,// minimum file size in bytes
                    'onComplete'=>"js:function(id, fileName, responseJSON){
                        $('#thumb').html(fileName);
                        $('#AdminArticlesModel_thumb').attr('value',fileName);
                    }",
                    //'messages'=>array(
                    //                  'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
                    //                  'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
                    //                  'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
                    //                  'emptyError'=>"{file} is empty, please select files again without it.",
                    //                  'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                    //                 ),
                    //'showMessage'=>"js:function(message){ alert(message); }"
                )
            )); ?>
        <input type="hidden" name="AdminArticlesModel[thumb]" id="AdminArticlesModel_thumb" value="" />
    </div>
	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title', array('class'=>'w-100')); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'introtext'); ?>
		<?php echo $form->textArea($model,'introtext', array('class'=>'w-100')); ?>
		<?php echo $form->error($model,'introtext'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fulltext'); ?>
        <?php
        $this->widget('ext.elrte.elRTE', array(
            'selector'=>'AdminArticlesModel_fulltext',
            'doctype' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">',
            'cssClass' => 'el-rte',
            'absoluteURLs' => 'false',
            'allowSource' => 'true',
            'lang' => 'en',
            'styleWithCSS' => 'true',
            'height' => '500',
            'width' => '100%',
            'fmAllow' => 'true',
            'toolbar' => 'maxi',
        ));
        echo $form->textArea($model, 'fulltext');
        ?>
        <?php echo $form->error($model,'fulltext'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'genre'); ?>
        <?php
            $data = CHtml::listData(AdminGenreModel::model()->findAll(),'code','name');
            echo $form->dropDownList($model,'genre',$data);
        ?>
		<?php echo $form->error($model,'genre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tags'); ?>
		<?php echo $form->textField($model,'tags'); ?>
		<?php echo $form->error($model,'tags'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'views'); ?>
		<?php echo $form->textField($model,'views'); ?>
		<?php echo $form->error($model,'views'); ?>
	</div>

	<!--<div class="row">
		<?php /*echo $form->labelEx($model,'thumb'); */?>
		<?php /*echo $form->textField($model,'thumb'); */?>
		<?php /*echo $form->error($model,'thumb'); */?>
	</div>-->

	<div class="row">
		<?php echo $form->labelEx($model,'comments'); ?>
		<?php echo $form->textField($model,'comments'); ?>
		<?php echo $form->error($model,'comments'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url_source'); ?>
		<?php echo $form->textField($model,'url_source'); ?>
		<?php echo $form->error($model,'url_source'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'source'); ?>
		<?php echo $form->textField($model,'source'); ?>
		<?php echo $form->error($model,'source'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_datetime'); ?>
		<?php echo $form->textField($model,'created_datetime'); ?>
		<?php echo $form->error($model,'created_datetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated_datetime'); ?>
		<?php echo $form->textField($model,'updated_datetime'); ?>
		<?php echo $form->error($model,'updated_datetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'active_datetime'); ?>
		<?php echo $form->textField($model,'active_datetime'); ?>
		<?php echo $form->error($model,'active_datetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by'); ?>
		<?php echo $form->error($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
        <div class="btn-group options-group" data-toggle="buttons">
            <label class="btn btn-default <?php if($model->status==1) echo 'active';?>">
                <input type="radio" name="AdminArticlesModel[status]" id="option1" value="1" autocomplete="off" <?php if($model->status==1) echo 'checked';?>> Actived
            </label>
            <label class="btn btn-default <?php if($model->status==0) echo 'active';?>">
                <input type="radio" name="AdminArticlesModel[status]" id="option2" value="0" autocomplete="off" <?php if($model->status==0) echo 'checked';?>> Wait Approve
            </label>
            <label class="btn btn-default <?php if($model->status==2) echo 'active';?>">
                <input type="radio" name="AdminArticlesModel[status]" id="option3" value="2" autocomplete="off" <?php if($model->status==2) echo 'checked';?>> Deleted
            </label>
        </div>

		<?php
        echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-success btn-sm')); ?>
	</div>
    <div class="row buttons">
        <?php $this->renderPartial('application.views.layouts._button_form');?>
    </div>
<?php $this->endWidget(); ?>

</div><!-- form -->