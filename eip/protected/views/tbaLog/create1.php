<?php
/* @var $this TbaLogController */
/* @var $model TbaLog */

$this->menu=array(	
	array('label'=>'回管理畫面', 'url'=>array('querylog')),
);
?>



<h1>建立請假單</h1>

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
        
         <td>

            <?php echo $form->labelEx($model,'logday'); ?>:
      
             <br> 
            <?php
            
            $dateAry=array();
            
            $date= date('Ymd');

            // 往1個月, 往後3個月                
            $last_month = date("Ymd", strtotime('-1 month')); //找尋前1個月
            $next_three_month = date("Ymd", strtotime('+3 month')); //找下3個月

            while (strtotime($last_month) <= strtotime($next_three_month)) {
            //echo "$last_month\n";
            array_push($dateAry, $next_three_month);
            $next_three_month = date ("Ymd", strtotime("-1 day", strtotime($next_three_month)));
            }
                   
                echo "<select name='datemulti[]' size=7 multiple >";

                for($i=0;$i<count($dateAry);$i++){
                    
                   /* if($dateAry[$i] == $date){
                      echo  "<option selected value ='$dateAry[$i]'>".$dateAry[$i]."</option>";
                    }   */                    
                      echo "<option value ='$dateAry[$i]'>".$dateAry[$i]."</option>";
                    
                }
                echo "</select>";
                
                // CVarDumper::dump($dateAry,10,true);
            ?>
     	
        </td>
        
        
        <td width="20%" >
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
      門市 *：
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
      <?php echo $form->error($model,'storecode'); ?>
      
<br>
      
    員工 *：
<?php
    echo $form->dropDownList($model,'empno', CHtml::listData(
                TbsEmpMonth::model()->findAll(
                        array('order'=>'id ASC','condition'=>'opt3<>2')),'empno', 'empname'),
                        array('empty' => '選擇員工')
            );
?>              

    <?php echo $form->error($model,'empno'); ?>
      
        </td>
       
        <td>
		
            <?php echo $form->labelEx($model,'logitem'); ?>
            <?php echo $form->dropDownList($model,'logitem', CHtml::listData(
                TbaLogItem::model()->findAll(
                        array('order'=>'seqno','condition'=>"logtype='1' AND optshow='1' AND opt2='0' ")),'id', 'logname')
//                        array('empty' => '選擇員工')
            ); ?>
            <?php echo $form->error($model,'logitem'); ?>
        </td>
        <td>
            <?php // echo $form->labelEx($model,'num'); ?>*
            <?php echo $form->radioButtonList($model,'num',array('0.5'=>'半天','1'=>'全天'), array('separator' =>' ')); ?>
                    
            <?php echo $form->error($model,'num'); ?>
      </td>
        <td>     
            <?php echo $form->labelEx($model,'leavecheck'); ?>
            <?php echo $form->checkbox($model,'leavecheck'); ?>
            <?php echo $form->error($model,'leavecheck'); ?>

            <?php echo $form->labelEx($model,'provecheck'); ?>
            <?php echo $form->checkbox($model,'provecheck'); ?>
            <?php echo $form->error($model,'provecheck'); ?>

            <?php echo $form->labelEx($model,'classcheck'); ?>
            <?php echo $form->checkbox($model,'classcheck'); ?>
            <?php echo $form->error($model,'classcheck'); ?>            
            
        </td>
    </tr>
    <tr>

        <td >
            <?php echo $form->labelEx($model,'memo'); ?>
</td>
        <td colspan="3">
            <?php echo $form->textArea($model,'memo',array('rows' => 2, 'cols' => 80 ,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'memo'); ?>
        </td>

        <td>            
                   <?php echo CHtml::submitButton('新增',array('name'=>'batch')); ?>
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
        $log->opt2 = 0;
        $this->renderPartial('_querylog', array('model'=>$log));
?>
