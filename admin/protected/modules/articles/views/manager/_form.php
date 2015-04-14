<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'admin-articles-model-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'introtext'); ?>
		<?php echo $form->textField($model,'introtext'); ?>
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
		<?php echo $form->textField($model,'genre'); ?>
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

	<div class="row">
		<?php echo $form->labelEx($model,'thumb'); ?>
		<?php echo $form->textField($model,'thumb'); ?>
		<?php echo $form->error($model,'thumb'); ?>
	</div>

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
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php //echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-success btn-sm')); ?>
	</div>
    <div class="row buttons">
        <?php $this->renderPartial('application.views.layouts._button_form');?>
    </div>
<?php $this->endWidget(); ?>

</div><!-- form -->