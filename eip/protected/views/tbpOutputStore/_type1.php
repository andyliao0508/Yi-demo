<!--<table>
    <tr>-->
    
<input type="hidden" name=<?php echo "TbpOutputLog[$row][num]" ?> value="<?php echo $model->num; ?>" />
<!--金額:&nbsp;<input type="text"  name=<?php //echo "TbpOutputLog[$row][price]" ?> value="<?php //echo $model->price; ?>" <?php  //echo $model->opt1==0 ? "disabled" :"" ?> maxlength=8 size=4 />-->
<input type="hidden" name=<?php echo "TbpOutputLog[$row][dates]" ?> value=""  maxlength=8 size=4 />
<input type="hidden" name=<?php echo "TbpOutputLog[$row][datee]" ?> value=""  maxlength=8 size=4 />
<input type="hidden" name=<?php echo "TbpOutputLog[$row][tmp1]" ?> value=""  />
<input type="hidden" name=<?php echo "TbpOutputLog[$row][tmp2]" ?> value=""  />
<input type="hidden" name=<?php echo "TbpOutputLog[$row][tmp3]" ?> value=""  />
<!--備註:&nbsp;<input type="textArea" name=<?php //echo "TbpOutputLog[$row][memo]" ?> value="<?php //echo $model->memo; ?>"  maxlength=30 size=40 />-->
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
</table> -->