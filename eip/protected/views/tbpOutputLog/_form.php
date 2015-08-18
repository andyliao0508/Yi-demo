<?php
/* @var $this TbpOutputLogController */
/* @var $model TbpOutputLog */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tbp-output-log-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'pdate'); ?>
		<?php echo $form->textField($model,'pdate',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'pdate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'storecode'); ?>
		<?php echo $form->textField($model,'storecode',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'storecode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'storename'); ?>
		<?php echo $form->textField($model,'storename',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'storename'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'itemid'); ?>
		<?php echo $form->textField($model,'itemid',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'itemid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'itemname'); ?>
		<?php echo $form->textField($model,'itemname',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'itemname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mainid'); ?>
		<?php echo $form->textField($model,'mainid',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'mainid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subid'); ?>
		<?php echo $form->textField($model,'subid',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'subid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'feeno'); ?>
		<?php echo $form->textField($model,'feeno',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'feeno'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'account'); ?>
		<?php echo $form->textField($model,'account',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'account'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'num'); ?>
		<?php echo $form->textField($model,'num',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'num'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dates'); ?>
		<?php echo $form->textField($model,'dates',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'dates'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'datee'); ?>
		<?php echo $form->textField($model,'datee',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'datee'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'temp1'); ?>
		<?php echo $form->textField($model,'temp1',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'temp1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'temp2'); ?>
		<?php echo $form->textField($model,'temp2',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'temp2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'temp3'); ?>
		<?php echo $form->textField($model,'temp3',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'temp3'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'memo'); ?>
		<?php echo $form->textField($model,'memo',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'memo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'opt1'); ?>
		<?php echo $form->textField($model,'opt1',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'opt1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cemp'); ?>
		<?php echo $form->textField($model,'cemp',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'cemp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'uemp'); ?>
		<?php echo $form->textField($model,'uemp',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'uemp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ctime'); ?>
		<?php echo $form->textField($model,'ctime'); ?>
		<?php echo $form->error($model,'ctime'); ?>
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