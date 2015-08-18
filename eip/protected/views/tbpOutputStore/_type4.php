<!--<table>
    <tr>-->

<!--月份:&nbsp;<input type="text" name=<?php //echo "TbpOutputLog[$row][num]" ?> value='<?php //echo $model->num; ?>' <?php  //echo $model->opt1==0 ? "disabled" :"" ?>  maxlength=8 size=4 />-->
<!--金額:&nbsp;<input type="text" name=<?php //echo "TbpOutputLog[$row][price]" ?> value="<?php //echo $model->price; ?>" <?php  //echo $model->opt1==0 ? "disabled" :"" ?>  maxlength=8 size=4 />-->

月份:&nbsp;
<?php
    echo  CHtml::dropDownList('TbpOutputLog['.$row.'][num]',$model->num, 
               array('1'=>'一月','2'=>'二月','3'=>'三月','4'=>'四月','5'=>'五月','6'=>'六月','7'=>'七月','8'=>'八月','9'=>'九月','10'=>'十月','11'=>'十一月','12'=>'十二月'),
             array(
                  "disabled"=>$model->opt1==0?"disabled" :'', //以opt1判斷是否disable
              ));       
?> 

<input type="hidden" name=<?php echo "TbpOutputLog[$row][dates]" ?> value=""  maxlength=8 size=4 />
<input type="hidden" name=<?php echo "TbpOutputLog[$row][datee]" ?> value=""  maxlength=8 size=4 />
<input type="hidden" name=<?php echo "TbpOutputLog[$row][tmp1]" ?> value=""  />
<input type="hidden" name=<?php echo "TbpOutputLog[$row][tmp2]" ?> value=""  />
<input type="hidden" name=<?php echo "TbpOutputLog[$row][tmp3]" ?> value=""  />
<!--備註:&nbsp;<input type="text" name=<?php //echo "TbpOutputLog[$row][memo]" ?> value="<?php //echo $model->memo; ?>"  maxlength=30 size=40 />-->
<?php //echo CHtml::activeTextArea($model,"[$row]memo",array('rows'=>1, 'cols'=>4)); ?>
<input type="hidden" name=<?php echo "TbpOutputLog[$row][opt1]" ?> value="<?php echo $model->opt1; ?>" />


    <?php if(isset($summary) && $summary!=''){
                    echo "<font size='4' color='red' >提示:</font>&nbsp";
                    echo "<font size='4' color='blue' >";
                    echo $summary;   
                    echo "</font>";
                    }
    ?>


<!--    </tr>
</table>-->