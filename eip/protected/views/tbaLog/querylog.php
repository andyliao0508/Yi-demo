
<?php
/* @var $this TbaLogController */
/* @var $model TbaLog */

$this->menu=array(	
	array('label'=>'建立請假單', 'url'=>array('create1')),
                   array('label'=>'建立遲到早退', 'url'=>array('create2')),
                   array('label'=>'建立奬懲單', 'url'=>array('create3')),
);

Yii::app()->clientScript->registerScript('search', "

$('.search-form form').submit(function(){
	$('#tba-log-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");


?>

<h1>差勤奬懲管理</h1>

<!-- 執行假單、證明、輪值的ajax -->
<script type='text/javascript'>

jQuery('#tba-log-grid a.for-leave-prove-class').live('click',function() {
    
        if(!confirm('你確定要執行此動作?')) return false;
       
        var url = $(this).attr('href');
        //  do your post request here
        $.post(url,function(){    
            $.fn.yiiGridView.update('tba-log-grid');       
        });

        return false;
});

</script>



<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<div class="tableBlue">
       <table >
         <tr>
             <td width="30%">               
                 <?php
                    // Date range search inputs
                    $attribute = 'logday';
                    for ($i = 0; $i <= 1; $i++)
                    {
                        echo ($i == 0 ? Yii::t('main', '日期起:') : Yii::t('main', '日期迄:'));
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'id'=>CHtml::activeId($model, $attribute.'_'.$i),
                            'model'=>$model,
                            'attribute'=>$attribute."[$i]",
                            'name'=>$attribute."[$i]",
                            'options'=> array(
                            'dateFormat' =>'yymmdd',
                            'altFormat' =>'yymmdd',
                            'changeMonth' => true,
                            'changeYear' => true,
                             ),
                             'htmlOptions'=>array(
                            'style'=>'width:100px; font-size: 120%'
                            ),
                            
                        )); 
                    }
                    ?>
             
             </td>
             
             <td width="10%">
                <?php echo $form->label($model,'logtype'); ?>
             </td>
             
             <td width="20%">
                 <?php //echo $form->textField($model,'logtype',array('size'=>2,'maxlength'=>2)); ?>
                 <?php 
//                 echo $form->dropDownList($model,'logtype',CHtml::listData(TbaLogtype::model()->findAll(array('order' => 'id ASC','condition'=>'opt1=1')
//                         ), 'id', 'cname'), array('empty' => '選擇類別', 'options' => array(' ' => array('selected' => 'selected'))));                
                 ?>
                <?php
                    echo $form->dropDownList($model,'logtype', 
                                CHtml::listData(TbaLogType::model()->findAll(array('order' => 'id ASC','condition'=>'opt1=1')), 'id', 'cname'),
                                array(
                                    'prompt'=>'選擇類別',
//                                    'options' => array($model->logtype => array('selected' => 'selected')),
                                    'ajax' => array(
                                    'type'=>'POST', //request type
                                    'url'=>CController::createUrl('tbsCom/dynamiclogitems',array('model'=>'TbaLog','column'=>'logtype')), //url to call.
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
             </td>
             
             <td width="25%">
                 員編:<?php echo $form->textField($model,'empno',array('size'=>8,'maxlength'=>8)); ?>
                 姓名:<?php echo $form->textField($model,'empname',array('size'=>8,'maxlength'=>8)); ?>
             </td>
             <td  width="8%">
                 遲到:<?php echo $form->checkBox($model,'opt2'); ?> 
             </td>
             <!--
                假單:<?php echo $form->checkBox($model,'leavecheck'); ?><br>
                 證明:<?php echo $form->checkBox($model,'provecheck'); ?><br>
                 輪值:<?php echo $form->checkBox($model,'classcheck'); ?> 
             -->
             <td>      
                 <?php echo CHtml::submitButton('查詢',array('name'=>'qry')); ?>                  
             </td>
         </tr>
         
     </table>
</div>    
<?php $this->endWidget(); ?>
    
<?php 

    $bg1 = 'background:YELLOW';
    $bg2 = 'background:GREEN';
    $bg3 = 'background:RED';
    $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tba-log-grid',
	'dataProvider'=>$model->search(),
//                   'filter'=>$model,
	'columns'=>array(
//                        'id',
                        array(
                            'name'=>'logday',
                            'value'=>'Yii::app()->dateFormatter->format("y-MM-dd",strtotime($data->logday))'
                        ),       
                        'storename',
                        'empname',
                        'logname',
                        array(
                            'name'=>'num',
                            'value'=>'Yii::app()->NumberFormatter->format("##.#",$data->num)'
                        ),       
                        'memo',
                        'cemp',
                        array(
                            'name'=>'ctime',
                            'value'=>'Yii::app()->dateFormatter->format("y-MM-dd",strtotime($data->ctime))'
                        ),            
                
                        array(                                 //新增可操作按鈕
                            'header'=>' ',
                            'class'=>'CButtonColumn',
                            'template'=>'{leave1}{leave2}',       //yii預設
                            'buttons'=>array(
                                'leave1'=>array(   //與'template'名稱對應
                                            'label'=>'假單',  
                                             'url'=>'Yii::app()->createUrl("tbaLog/updateLeave", array("id"=>$data->id))',               
                                            'options'=>array('class'=>'for-leave-prove-class'),
                                            'visible'=>'$data->leavecheck == "1" && $data->logtype =="1" && $data->opt2 =="0"',     //是否隱藏 1是0否
                                        ),
                                'leave2'=>array(
                                            'label'=>'假單',  
                                             'url'=>'Yii::app()->createUrl("tbaLog/updateLeave", array("id"=>$data->id))',               
                                            'options'=>array('class'=>'for-leave-prove-class','style'=>$bg1),
                                            'visible'=>'$data->leavecheck== "0" && $data->logtype =="1" && $data->opt2 =="0"', 
                                        ),                
                                ),
                        ),
                        array(
                            'header'=>' ',
                            'class'=>'CButtonColumn',
                            'template'=>'{prove1}{prove2}',
                            'buttons'=>array(
                                'prove1'=>array(
                                    'label'=>'證明',  
                                    'url'=>'Yii::app()->createUrl("tbaLog/updateProve", array("id"=>$data->id))',  
                                    'options'=>array('class'=>'for-leave-prove-class'),
                                     'visible'=>'$data->provecheck == "1" && $data->logtype =="1" && $data->opt2 =="0"', 
                                ), 
                            'prove2'=>array(
                                    'label'=>'證明',  
                                    'url'=>'Yii::app()->createUrl("tbaLog/updateProve", array("id"=>$data->id))',  
                                    'options'=>array('class'=>'for-leave-prove-class','style'=>$bg2),
                                    'visible'=>'$data->provecheck == "0" && $data->logtype =="1" && $data->opt2 =="0"', 
                                ),    
                            ),
                        ),
                        array(
                            'header'=>' ',
                            'class'=>'CButtonColumn',
                            'template'=>'{class1}{class2}',
                            'buttons'=>array(
                                'class1'=>array(
                                    'label'=>'輪值',  
                                     'url'=>'Yii::app()->createUrl("tbaLog/updateClass", array("id"=>$data->id))',   
                                     'options'=>array('class'=>'for-leave-prove-class'),
                                     'visible'=>'$data->classcheck == "1" && $data->logtype =="1" && $data->opt2 =="0"', 
                                ),
                                'class2'=>array(
                                     'label'=>'輪值',  
                                     'url'=>'Yii::app()->createUrl("tbaLog/updateClass", array("id"=>$data->id))',   
                                     'options'=>array('class'=>'for-leave-prove-class','style'=>$bg3),
                                     'visible'=>'$data->classcheck == "0" && $data->logtype =="1" && $data->opt2 =="0"', 
                                ),
                            ),
                        ),
                        array(
                                 'class'=>'CButtonColumn',
                                 'header' => '操作',  
                                 'template'=>'{update}{delete}',
                         ),
                    ),
                )
            ); 
?>
