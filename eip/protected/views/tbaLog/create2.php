<?php
/* @var $this TbaLogController */
/* @var $model TbaLog */
$this->menu=array(	
	array('label'=>'回管理畫面', 'url'=>array('querylog')),
);
?>

<h1>建立遲到早退</h1>

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
                    'update'=>'#qry_store', //selector to update
                    //'data'=>'js:javascript statement' 
                    //leave out the data key to pass all form values through
    )));       
?>
        </td>
        <td>
      門市：
        <?php
            echo CHtml::dropDownList('qry_store','', 
                        CHtml::listData(
                            TbsStore::model()->findAll(
                                array('order'=>'id ASC','condition'=>'opt1=1')),'storecode', 'storename'),
                                array(
                            'prompt'=>'選擇門市',
                            'options' => array($qry_store => array('selected' => 'selected')),
                            'ajax' => array(
                            'type'=>'POST', //request type
                            'url'=>CController::createUrl('tbaLog/dynamicemps',array('empty'=>FALSE)), //url to call.
                            //Style: CController::createUrl('currentController/methodToCall')
                            'update'=>'#TbaLog_empno', //selector to update
                            //'data'=>'js:javascript statement' 
                            //leave out the data key to pass all form values through
            )));       
        ?>        
        </td>
        <td>
        
            <?php echo $form->labelEx($model,'logday'); ?>
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'name' => 'logday',
                                'attribute' => 'logday',
                                'value'  => "$logday",
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
            <?php echo CHtml::dropDownList('logitem',$logitem,CHtml::listData(
                 TbaLogItem::model()->findAll(array('order'=>'seqno ASC','condition'=>'opt2=1')),'id', 'logname'));
            ?>
            <?php echo $form->error($model,'logitem'); ?>
	
        </td>        
    </tr>
</table>
    <br>
<div id="TbaLog_empno">

</div>
    <br>
<table>    
    <tr>
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
        
        $log->logtype = 1;
        $log->opt2 = 1;
        $this->renderPartial('_querylog', array('model'=>$log));
?>
