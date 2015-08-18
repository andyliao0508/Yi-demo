<?php
/* @var $this TbaWeightController */
/* @var $model TbaWeight */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tba-weight-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

    <p class="note">欄位 <span class="required">*</span>是必填.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
            <?php echo $form->labelEx($model,'logitem'); ?> 
            <?php
                                        echo $form->dropDownList($model,'logitem', CHtml::listData(
                                                        TbaLogItem::model()->findAll(array('order' => 'logtype ASC,seqno ASC','condition'=>'weight=1 AND opt1=1')), 'id', 'logname'),
                                                            array('empty' => '選擇項目')
                                                );
                                  ?>             
            <?php echo $form->error($model,'logitem'); ?>
    </div>

    <div class="row">
            <?php echo $form->labelEx($model,'nweight'); ?>
            <?php echo $form->textField($model,'nweight',array('size'=>3,'maxlength'=>3)); ?>
            <?php echo $form->error($model,'nweight'); ?>
    </div>

    <div class="row">
            <?php echo $form->labelEx($model,'hweight'); ?>
            <?php echo $form->textField($model,'hweight',array('size'=>3,'maxlength'=>3)); ?>
            <?php echo $form->error($model,'hweight'); ?>
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
    </div>

    <div class="row">
            <?php echo $form->labelEx($model,'opt2'); ?>
            <?php echo $form->radioButtonList($model,'opt2', array( '1' => '是', '0' => '否' ), array('separator' =>' ')); ?>
            <?php echo $form->error($model,'opt2'); ?>
    </div>

    <!--<div class="row">
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