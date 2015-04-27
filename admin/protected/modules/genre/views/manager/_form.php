<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'admin-genre-model-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'code'); ?>
		<?php echo $form->textField($model,'code'); ?>
		<?php echo $form->error($model,'code'); ?>
	</div>
    <div class="row">
		<?php echo $form->labelEx($model,'url_key'); ?>
		<?php echo $form->textField($model,'url_key'); ?>
		<?php echo $form->error($model,'url_key'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description'); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'parent'); ?>
		<?php
            $c = array(
                'conditions'=>array(
                    'status'=>array('==' => 1),
                ),
            );
            if($model->_id){
                $c['conditions']['_id'] = array('<>'=>$model->_id);
            }
            $genres = AdminGenreModel::model()->findAll($c);
            $data = array();
            foreach($genres as $genre){
                $data["{$genre->_id}"] = $genre->name;
            }
        echo CHtml::dropDownList('AdminGenreModel[parent]',(string)$model->parent,$data, array('prompt'=>'--None--','class'=>'form-control'));
        ?>
		<?php echo $form->error($model,'parent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'position'); ?>
		<?php echo $form->textField($model,'position'); ?>
		<?php echo $form->error($model,'position'); ?>
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
                <input type="radio" name="AdminGenreModel[status]" id="option1" value="1" autocomplete="off" <?php if($model->status==1) echo 'checked';?>> Actived
            </label>
            <label class="btn btn-default <?php if($model->status==0) echo 'active';?>">
                <input type="radio" name="AdminGenreModel[status]" id="option2" value="0" autocomplete="off" <?php if($model->status==0) echo 'checked';?>> Wait Approve
            </label>
            <label class="btn btn-default <?php if($model->status==2) echo 'active';?>">
                <input type="radio" name="AdminGenreModel[status]" id="option3" value="2" autocomplete="off" <?php if($model->status==2) echo 'checked';?>> Deleted
            </label>
        </div>
		<?php echo $form->error($model,'status'); ?>
	</div>

    <div class="row buttons">
        <?php $this->renderPartial('application.views.layouts._button_form');?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->