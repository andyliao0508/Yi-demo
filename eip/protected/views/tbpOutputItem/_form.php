<?php
/* @var $this TbpOutputItemController */
/* @var $model TbpOutputItem */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tbp-output-item-form',
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

	<div class="row">
                      
            <?php
                    echo  $form->dropDownList($model,'mainid', 
                                CHtml::listData(TbpOutputMain::model()->findAll(array('order' => 'id ASC','condition'=>'opt1=1')), 'id', 'cname'),
                                array(
                                    'prompt'=>'選擇主項',
//                                    'options' => array($model->logtype => array('selected' => 'selected')),
                                    'ajax' => array(
                                    'type'=>'POST', //request type
                                    'url'=>CController::createUrl('tbsCom/dynamicoutputitems'), //url to call.
                                    //Style: CController::createUrl('currentController/methodToCall')
                                    'update'=>'#TbpOutputItem_subid', //selector to update
                                    //'data'=>'js:javascript statement' 
                                    //leave out the data key to pass all form values through
                    )));       
                ?> 
         
            <?php
//                    echo $form->labelEx($model,'subid');
                    echo $form->dropDownList($model,'subid', CHtml::listData(
                                    TbpOutputSub::model()->findAll(array('order' => 'id ASC','condition'=>'opt1=1')), 'id', 'cname'),
                                        array('empty' => '--選擇次項--')
                            );
            ?>         
     	
		<?php //echo $form->textField($model,'subid',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'subid'); ?>
	</div>

	<div class="row">
            
                <?php echo $form->labelEx($model,'type'); ?>
                <?php
                      echo $form->dropDownList($model,'type', 
                                array('1'=>'type1','2'=>'type2','3'=>'type3','4'=>'type4'),
                                  array(
                                      'prompt'=>'--type--',                                 
                                      ));       
                ?>
                &nbsp; <span class="required">型態分為四種.</span>
                <?php echo $form->error($model,'type'); ?>
	</div>
        <div class="row" style="color: blue;">
            <ul>
                <li>type1:金額.&nbsp;&nbsp;例如:修膳,郵資,交通費...等</li>
                <li style="color: green;">type2:日期起~迄、度數、金額.&nbsp;&nbsp;例如:電費,瓦斯費...等</li>
                <li>type3:數量、金額.&nbsp;&nbsp;例如:文具用品,清潔用品...等</li>
                <li style="color: green;">type4:月份、金額.&nbsp;&nbsp;例如:管理費,洗毛巾...等</li>
            </ul>
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
		<?php echo $form->labelEx($model,'summary'); ?>
		<?php echo $form->textField($model,'summary',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'summary'); ?>
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