<?php
/* @var $this TbaLogItemController */
/* @var $model TbaLogItem */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tba-log-item-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">欄位 <span class="required">*</span>是必填.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'logname'); ?>
		<?php echo $form->textField($model,'logname',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'logname'); ?>
	</div>

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

	<div class="row">
		<?php echo $form->labelEx($model,'logtype'); ?>
                                    <?php echo $form->dropDownList($model,'logtype', CHtml::listData(
                                        TbaLogType::model()->findAll(
                                                array('order'=>'id','condition'=>"opt1='1'")),'id', 'cname')
                                    ); ?>
		<?php echo $form->error($model,'logtype'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'seqno'); ?>
		<?php echo $form->textField($model,'seqno',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'seqno'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'days'); ?>
		<?php echo $form->textField($model,'days',array('size'=>5,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'days'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'baseday'); ?>
		<?php echo $form->textField($model,'baseday',array('size'=>2,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'baseday'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unit'); ?>
		<?php echo $form->radioButtonList($model,'unit', array( 'H' => '時','M'=>'分', 'D' => '天' ), array('separator' =>' ')); ?>
		<?php echo $form->error($model,'unit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sex'); ?>
		<?php echo $form->radioButtonList($model,'sex', array( '0'=>'不限','M' => '男', 'W' => '女' ), array('separator' =>' ')); ?>
		<?php echo $form->error($model,'sex'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'position'); ?>
		<?php echo $form->textField($model,'position',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'position'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'salaryitem'); ?>
		<?php echo $form->textField($model,'salaryitem',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'salaryitem'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'basewage'); ?>
		<?php echo $form->radioButtonList($model,'basewage',array( '0'=>'不給','1' => '全薪','2' => '半薪' ), array('separator' =>' ')); ?>
		<?php echo $form->error($model,'basewage'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'overtime'); ?>
		<?php echo $form->radioButtonList($model,'overtime',array( '0' => '無','1' => '有' ), array('separator' =>' ')); ?>
		<?php echo $form->error($model,'overtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'weight'); ?>
		<?php echo $form->radioButtonList($model,'weight',array('0'=>'無','1'=>'有'), array('separator' =>' ')); ?>
		<?php echo $form->error($model,'weight'); ?>
	</div>        
        
	<div class="row">
		<?php echo $form->labelEx($model,'optshow'); ?>
		<?php echo $form->radioButtonList($model,'optshow',array('1'=>'是','0'=>'否'), array('separator' =>' ')); ?>
		<?php echo $form->error($model,'optshow'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'memo'); ?>
		<?php echo $form->textField($model,'memo',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'memo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'opt1'); ?>
		<?php echo $form->radioButtonList($model,'opt1', array( '1' => '是', '0' => '否' ), array('separator' =>' ')); ?>
		<?php echo $form->error($model,'opt1'); ?>
                                        <span class="required">預設為是</span>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'opt2'); ?>
		<?php echo $form->radioButtonList($model,'opt2', array( '1' => '是', '0' => '否' ), array('separator' =>' ')); ?>
		<?php echo $form->error($model,'opt2'); ?>
                                        <span class="required">若設成是, 則直接以分鐘數計算權重, 目前用於遲到早退開小差, 預設為否</span>
	</div>

                   <div class="row">
		<?php echo $form->labelEx($model,'opt3'); ?>
		<?php echo $form->radioButtonList($model,'opt3', array( '1' => '是', '0' => '否' ), array('separator' =>' ')); ?>
		<?php echo $form->error($model,'opt3'); ?>
                                        <span class="required">若設成是, 則直接以數量計算權重, 目前用於客訴, 預設為否</span>
	</div>

	<!-- <div class="row">
		<?php echo $form->labelEx($model,'opt4'); ?>
		<?php echo $form->textField($model,'opt4',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'opt4'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'opt5'); ?>
		<?php echo $form->textField($model,'opt5',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'opt5'); ?>
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
	</div> -->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '建立' : '儲存'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
