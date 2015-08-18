<?php
/* @var $this TbaBoardController */
/* @var $model TbaBoard */
/* @var $form CActiveForm */
?>

<div class="tableBlue">
<script>
    $(function(){
        $('#general_bgColor').miniColors({ change: function(hex, rgb) { console.log('it worked!'); //console.log(hex + ' - ' + rgb); } });
    })
</script>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tba-board-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
    

        <?php echo $form->errorSummary($model); ?>
        <?php
        foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
        }
        ?>    
    
  
        <table style="width: 100%">
          
        <tr>
                      
            <td width="10%" ><?php echo $form->labelEx($model,'title'); ?></td>
            <td colspan="6" >
                
		<?php echo $form->textField($model,'title',array('size'=>40,'maxlength'=>255 ,'style'=>'width:90%;')); ?>
		<?php echo $form->error($model,'title'); ?>
            </td>
        </tr>
        <tr>
             <td >
                    <?php echo $form->labelEx($model,'dates'); ?>
             </td>
             <td width="10%">
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
                        array(
                            'model' => $model,
                            'name' => 'qry_dateS',
                            'attribute' => 'dates',
                            'value'  => "",
                            'options'=> array(
                            'dateFormat' =>'yymmdd',
                            'altFormat' =>'yymmdd',
                            'changeMonth' => true,
                            'changeYear' => true,
                             ),
                            'htmlOptions'=>array(
                            'style'=>'width:100px;'
                            ),
                            )); 
                    ?> 
                    <?php echo $form->error($model,'dates'); ?>
                 
               
                
            <td rowspan="5">
                <?php echo $form->fileField($model, 'image'); ?>
                <?php echo $form->error($model, 'image'); ?>
                <br>
                <?php 
                    if($model->imagename ){
                       echo CHtml::image(Yii::app()->request->baseUrl.$model->imageurl,"image",array("width"=>"200px","height"=>"150px"));
                    }
                ?>      
            </td>
       
             
                <td rowspan="6" width="10%"> <?php echo $form->labelEx($model,'content'); ?></td>
                <td rowspan="6">
             	
                <?php echo $form->textArea($model,'content',array('rows'=>8, 'cols'=>62 ,'style'=>"resize:none;width:99%; word-wrap:break-word;"));//style'=>'resize:none':固定寬高 ?> 
                    
		<?php echo $form->error($model,'content'); ?>
                </td>
        </tr>
        <tr>
            <td>
                    <?php echo $form->labelEx($model,'datee'); ?>
            </td>
            <td>
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
                        array(
                            'model' => $model,
                            'name' => 'qry_dateE',
                            'attribute' => 'datee',
                            'value'  => "",
                            'options'=> array(
                            'dateFormat' =>'yymmdd',
                            'altFormat' =>'yymmdd',
                            'changeMonth' => true,
                            'changeYear' => true,
                            ),
                            'htmlOptions'=>array(
                            'style'=>'width:100px;'
                            ),
                            )); 
                    ?>    
                    <?php echo $form->error($model,'datee'); ?>
                </td>
        </tr>
        
        <tr>
            <td >
                <?php echo $form->labelEx($model,'opt1'); ?>
            </td>
            <td>
                <?php echo $form->radioButtonList($model,'opt1', array( '1' => '是', '2' => '否' ), array('separator' =>' ')); ?>
		<?php echo $form->error($model,'opt1'); ?>
            </td>
        </tr>
        
        <tr>
             <td>
                <?php echo $form->labelEx($model,'opt2'); ?>
                     </td>
            <td>
		<?php echo $form->checkBox($model,'opt2'); ?>
		<?php echo $form->error($model,'opt2'); ?>
            </td>
        </tr>
        
          <tr>
             <td>
                <?php echo $form->labelEx($model,'opt3'); ?>
                     </td>
            <td>
		<?php echo $form->checkBox($model,'opt3'); ?>
		<?php echo $form->error($model,'opt3'); ?>
            </td>
        </tr>
        
       
        
        </table>
        
        <table>
            <tr>
                <td>
 	<?php echo CHtml::submitButton($model->isNewRecord ? '建立' : '儲存'); ?>
                </td>
            </tr>

        </table>
   

<?php $this->endWidget(); ?>

</div><!-- form -->