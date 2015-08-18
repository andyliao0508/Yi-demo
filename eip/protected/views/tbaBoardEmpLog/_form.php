<?php
/* @var $this TbaBoardEmpLogController */
/* @var $model TbaBoardEmpLog */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tba-board-emp-log-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'board_id'); ?>
		<?php echo $form->textField($model,'board_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'board_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'board_title'); ?>
		<?php echo $form->textField($model,'board_title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'board_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'empno'); ?>
		<?php echo $form->textField($model,'empno',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'empno'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'empname'); ?>
		<?php echo $form->textField($model,'empname',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'empname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'read'); ?>
		<?php echo $form->textField($model,'read',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'read'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'opt1'); ?>
		<?php echo $form->textField($model,'opt1',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'opt1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'opt2'); ?>
		<?php echo $form->textField($model,'opt2',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'opt2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'opt3'); ?>
		<?php echo $form->textField($model,'opt3',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'opt3'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cemp'); ?>
		<?php echo $form->textField($model,'cemp',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'cemp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ctime'); ?>
		<?php echo $form->textField($model,'ctime'); ?>
		<?php echo $form->error($model,'ctime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'uemp'); ?>
		<?php echo $form->textField($model,'uemp',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'uemp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'utime'); ?>
		<?php echo $form->textField($model,'utime'); ?>
		<?php echo $form->error($model,'utime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ip'); ?>
		<?php echo $form->textField($model,'ip',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'ip'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->