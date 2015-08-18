<?php
/* @var $this TbaParamController */
/* @var $model TbaParam */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tba-param-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'param'); ?>
		<?php echo $form->textField($model,'param',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'param'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cname'); ?>
		<?php echo $form->textField($model,'cname',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'cname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pvalue'); ?>
		<?php echo $form->textField($model,'pvalue',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'pvalue'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'memo'); ?>
		<?php echo $form->textField($model,'memo',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'memo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'opt1'); ?>
		<?php echo $form->radioButtonList($model,'opt1',array( '1' => '是', '0' => '否' ), array('separator' =>' ')); ?>
		<?php echo $form->error($model,'opt1'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '儲存'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->