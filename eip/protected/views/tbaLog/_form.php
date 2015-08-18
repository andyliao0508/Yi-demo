<?php
/* @var $this TbaLogController */
/* @var $model TbaLog */
/* @var $form CActiveForm */
?>

<div class="tableBlue">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tba-log-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<?php echo $form->errorSummary($model); ?>

<table>
    <tr>
        <td><?php echo $form->labelEx($model,'logday'); ?></td>
        <td>
            <?php
                 $this->widget('zii.widgets.jui.CJuiDatePicker', 
                        array(
                            'model' => $model,
                            'name' => 'logday',
                            'attribute' => 'logday',
                            'value'  => "",
                            'options'=> array(
                            'dateFormat' =>'yymmdd',
                            'altFormat' =>'yymmdd',
                            'changeMonth' => true,
                            'changeYear' => true,
                             ),
                            'htmlOptions'=>array(
                            'style'=>'width:100px; font-size:120%'
                            ),
                ));                    
            ?>
            <?php echo $form->error($model,'logday'); ?>
        </td>
        <td><?php echo $form->labelEx($model,'storename'); ?>*</td>
        <td>
            <?php // echo $form->textField($model,'storecode',array('size'=>6,'maxlength'=>6)); ?>
            <?php // echo $form->textField($model,'storename',array('size'=>10,'maxlength'=>10)); ?>
            <?php echo $form->dropDownList($model,'storecode',CHtml::listData(
                 TbsStore::model()->findAll(array('order'=>'storecode ASC','condition'=>'opt1=1')),'storecode', 'storename'));
            ?>
            <?php echo $form->error($model,'storecode'); ?>
            <?php echo $form->error($model,'storename'); ?>
        </td>

        <td><?php echo $form->labelEx($model,'empname'); ?>*</td>
        <td>
            <?php // echo $form->textField($model,'empno',array('size'=>8,'maxlength'=>8)); ?>
            <?php // echo $form->textField($model,'empname',array('size'=>10,'maxlength'=>20)); ?>
            <?php echo $form->dropDownList($model,'empno',CHtml::listData(
                 TbsEmp::model()->findAll(array('order'=>'empno ASC','condition'=>'opt1=1')),'empno', 'empname'));
            ?>
            <?php echo $form->error($model,'empno'); ?>
            <?php echo $form->error($model,'empname'); ?>
        </td> 
        <td><?php echo $form->labelEx($model,'logitem'); ?></td>
        <td>
            <?php // echo $form->textField($model,'logtype',array('size'=>2,'maxlength'=>2)); ?>
            <?php // echo $form->textField($model,'logitem',array('size'=>2,'maxlength'=>2)); ?>
            <?php // echo $form->textField($model,'logname',array('size'=>20,'maxlength'=>20)); ?>
            <?php
                    echo $form->dropDownList($model,'logtype', 
                                CHtml::listData(TbaLogType::model()->findAll(array('order' => 'id ASC','condition'=>'opt1=1')), 'id', 'cname'),
                                array(
                                    'prompt'=>'選擇類別',
//                                    'options' => array($model->logtype => array('selected' => 'selected')),
                                    'ajax' => array(
                                    'type'=>'POST', //request type
                                    'url'=>CController::createUrl('tbsCom/dynamiclogitems',array('model'=>'TbaLog','column'=>'logtype','empty'=>FALSE)), //url to call.
                                    //Style: CController::createUrl('currentController/methodToCall')
                                    'update'=>'#TbaLog_logitem', //selector to update
                                    //'data'=>'js:javascript statement' 
                                    //leave out the data key to pass all form values through
                    )));       
                ?>                 
                <?php
                    echo $form->dropDownList($model,'logitem', CHtml::listData(
                                    TbaLogItem::model()->findAll(array('order' => 'seqno ASC','condition'=>'optshow=1')), 'id', 'logname'),
                                        array('empty' => '選擇項目')
                            );
                ?>             
            
            <?php echo $form->error($model,'logtype'); ?>
            <?php echo $form->error($model,'logitem'); ?>
            <?php echo $form->error($model,'logname'); ?>
        </td>
        <td><?php echo $form->labelEx($model,'num'); ?></td>
        <td>
            <?php echo $form->textField($model,'num',array('size'=>4,'maxlength'=>4)); ?>
            <?php echo $form->error($model,'num'); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->labelEx($model,'leavecheck'); ?>
            <?php echo $form->checkBox($model,'leavecheck'); ?>
            <?php echo $form->error($model,'leavecheck'); ?>

            <?php echo $form->labelEx($model,'provecheck'); ?>
            <?php echo $form->checkBox($model,'provecheck'); ?>
            <?php echo $form->error($model,'provecheck'); ?>

            <?php echo $form->labelEx($model,'classcheck'); ?>
            <?php echo $form->checkBox($model,'classcheck'); ?>
            <?php echo $form->error($model,'classcheck'); ?>
        </td>
        <td><?php echo $form->labelEx($model,'memo'); ?></td>
        <td  colspan="4">
            <?php echo $form->textArea($model,'memo',array('rows' => 2, 'cols' => 60 ,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'memo'); ?>
        </td>
        <td  colspan="2" >
            <?php echo CHtml::submitButton($model->isNewRecord ? '建立' : '儲存'); ?>
        </td>
    </tr>
</table>

    <?php echo $form->hiddenField($model,'opt2'); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->