<?php
/* @var $this TbpOutputMainController */
/* @var $model TbpOutputMain */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tbp-output-main-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">欄位 <span class="required">*</span>是必填.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cname'); ?>
		<?php echo $form->textField($model,'cname',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'cname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ename'); ?>
		<?php echo $form->textField($model,'ename',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'ename'); ?>
	</div>

<!--	<div class="row">
		<?php echo $form->labelEx($model,'feeno'); ?>
		<?php echo $form->textField($model,'feeno',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'feeno'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'account'); ?>
		<?php echo $form->textField($model,'account',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'account'); ?>
	</div>-->

	<div class="row">
		<?php echo $form->labelEx($model,'memo'); ?>
		<?php echo $form->textField($model,'memo',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'memo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'opt1'); ?>
		<?php echo $form->radioButtonList($model,'opt1', array( '1' => '是', '0' => '否' ), array('separator' =>' ')); ?>
		<?php echo $form->error($model,'opt1'); ?>
	</div>

<!--	<div class="row">
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
	</div>-->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '建立' : '儲存'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->