<?php
/* @var $this TbaLogController */
/* @var $model TbaLog */

$this->menu=array(	
	array('label'=>'回管理畫面', 'url'=>array('querylog')),
);

?>

<h1>建立獎懲單</h1>

<div class="tableBlue">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tba-log-form',
	'enableAjaxValidation'=>false,
)); ?>

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>	

	<?php echo $form->errorSummary($model); ?>
<table>
    <tr>
        <td >
      區域：
<?php
    echo CHtml::dropDownList('qry_area','', 
                CHtml::listData(
                    TbsArea::model()->findAll(array('order'=>'id ASC','condition'=>'opt1=1')), 'id', 'areaname'),
                array(
                    'prompt'=>'選擇分區',
                    'options' => array($qry_area => array('selected' => 'selected')),
                    'ajax' => array(
                    'type'=>'POST', //request type
                    'url'=>CController::createUrl('tbsCom/dynamicstores',array('update'=>'qry_area')), //url to call.
                    //Style: CController::createUrl('currentController/methodToCall')
                    'update'=>'#TbaLog_storecode', //selector to update
                    //'data'=>'js:javascript statement' 
                    //leave out the data key to pass all form values through
    )));       
?>
<br>
      門市：
<?php
    echo $form->dropDownList($model,'storecode', 
                CHtml::listData(
                    TbsStore::model()->findAll(
                        array('order'=>'id ASC','condition'=>'opt1=1')),'storecode', 'storename'),
                        array(
                    'prompt'=>'選擇門市',
//                    'options' => array($qry_store => array('selected' => 'selected')),
                    'ajax' => array(
                    'type'=>'POST', //request type
                    'url'=>CController::createUrl('tbsCom/dynamicemps',array('model'=>'TbaLog','column'=>'storecode','empty'=>FALSE)), //url to call.
                    //Style: CController::createUrl('currentController/methodToCall')
                    'update'=>'#TbaLog_empno', //selector to update
                    //'data'=>'js:javascript statement' 
                    //leave out the data key to pass all form values through
    )));       
?>        
        </td>
        <td>
員工 *：
<?php
    echo $form->dropDownList($model,'empno', CHtml::listData(
                TbsEmpMonth::model()->findAll(
                        array('order'=>'id ASC','condition'=>'opt3<>2')),'empno', 'empname'),
                        array('empty' => '選擇員工')
            );
?>              

            <?php echo $form->error($model,'empno'); ?>
      <br>            

        
            <?php echo $form->labelEx($model,'logday'); ?>
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model'=>$model,
                                'attribute'=>'logday',
                                'options'=>array(
                                    'showAnim'=>'slideDown',
                                    'changeMonth'=>true,
                                    'changeYear'=>true,
                                    'dateFormat' => 'yymmdd'
                                ),
                                'htmlOptions'=>array(
                                    'style'=>'width:100px;'
                                ),
                            )
                        );
            ?>
            <?php echo $form->error($model,'logday'); ?>
	
        </td>
        <td>
		
            <?php echo $form->labelEx($model,'logitem'); ?>
            <?php echo $form->dropDownList($model,'logitem', CHtml::listData(
                TbaLogItem::model()->findAll(
                        array('order'=>'seqno','condition'=>"logtype='2' AND optshow='1' ")),'id', 'logname')
//                        array('empty' => '選擇員工')
            ); ?>
            <?php echo $form->error($model,'logitem'); ?>
        </td>
        <td>
            <?php echo $form->labelEx($model,'num'); ?>
            <?php echo $form->textField($model,'num',array('size'=>4,'maxlength'=>4)); ?>
            
            
            <?php echo $form->error($model,'num'); ?>
      </td>
<!--        <td>     
            <?php echo $form->labelEx($model,'leavecheck'); ?>
            <?php echo $form->checkbox($model,'leavecheck'); ?>
            <?php echo $form->error($model,'leavecheck'); ?>

            <?php echo $form->labelEx($model,'provecheck'); ?>
            <?php echo $form->checkbox($model,'provecheck'); ?>
            <?php echo $form->error($model,'provecheck'); ?>

            <?php echo $form->labelEx($model,'classcheck'); ?>
            <?php echo $form->checkbox($model,'classcheck'); ?>
            <?php echo $form->error($model,'classcheck'); ?>            
            
        </td>-->
    </tr>
    <tr>

        <td >
            <?php echo $form->labelEx($model,'memo'); ?>
</td>
        <td colspan="2">
            <?php echo $form->textArea($model,'memo',array('rows' => 2, 'cols' => 80 ,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'memo'); ?>
        </td>

        <td>
            	<?php echo CHtml::submitButton('新增',array('name'=>'create')); ?>
        </td>
    </tr>
	
</table>                
<?php $this->endWidget(); ?>

</div>

<?php
        $log=new TbaLog('search');
        $log->unsetAttributes();  // clear any default values
        if(isset($_GET['TbaLog']))
                $log->attributes=$_GET['TbaLog'];        
        
        $log->logtype = 2;
        $log->opt2 = 0;
        $this->renderPartial('_querylog', array('model'=>$log));
?>
