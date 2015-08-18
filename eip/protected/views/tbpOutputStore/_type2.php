
<!--<table>
    <tr>-->

度數:&nbsp;<input type="text" name=<?php echo "TbpOutputLog[$row][num]" ?> value="<?php echo $model->num; ?>" <?php  echo $model->opt1==0 ? "disabled" :"" ?>  maxlength=8 size=4 />
<!--金額:<input type="text" name=<?php //echo "TbpOutputLog[$row][price]" ?> value="<?php //echo $model->price; ?>" <?php  //echo $model->opt1==0 ? "disabled" :"" ?>  maxlength=8 size=4 />-->

 日起:&nbsp;<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                'name'=>'TbpOutputLog['.$row.'][dates]',
                'attribute' => 'dates',
                'language' => 'zh-tw',
                 'value'  =>"$model->dates",
                'options'=>array(
                    'showAnim'=>'fold',
                    'changeMonth'=>true,
//                    'changeYear'=>true,
                    'dateFormat' => 'yymmdd',
                    'disabled'=>$model->opt1==0? true:false,
                ),
              //  'model'=>$model,
                'htmlOptions'=>array(
                'style'=>'width:80px;',
                'maxlength'=>8,
                ),
            ));
 ?>

日迄:&nbsp;<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                'name'=>'TbpOutputLog['.$row.'][datee]',
                'attribute' => 'datee',    
                'language' => 'zh-tw',
                 'value'  =>"$model->datee",   
                'options'=>array(
                    'showAnim'=>'fold',
                    'changeMonth'=>true,
//                    'changeYear'=>true,
                    'dateFormat' => 'yymmdd',
                    'disabled'=>$model->opt1==0? true:false,
                ),
              //  'model'=>$model,
                'htmlOptions'=>array(
                'style'=>'width:80px;',
                'maxlength'=>8,
                ),
            ));
 ?>

<input type="hidden" name=<?php echo "TbpOutputLog[$row][tmp1]" ?> value=""  />
<input type="hidden" name=<?php echo "TbpOutputLog[$row][tmp2]" ?> value=""  />
<input type="hidden" name=<?php echo "TbpOutputLog[$row][tmp3]" ?> value=""  />
<!--備註:&nbsp;<input type="text" name=<?php //echo "TbpOutputLog[$row][memo]" ?> value="<?php //echo $model->memo; ?>"  maxlength=30 size=40 />-->
<?php //echo CHtml::activeTextArea($model,"[$row]memo",array('rows'=>1, 'cols'=>4)); ?>
<input type="hidden" name=<?php echo "TbpOutputLog[$row][opt1]" ?> value="<?php echo $model->opt1; ?>" />
<!--    </tr>-->
    
<br>
    <?php if(isset($summary) && $summary!=''){
                echo "<font size='4' color='red' >提示:</font>&nbsp";
                echo "<font size='4' color='blue' >";
                echo $summary;   
                echo "</font>";
                }
    ?>
<!--    
</table>-->