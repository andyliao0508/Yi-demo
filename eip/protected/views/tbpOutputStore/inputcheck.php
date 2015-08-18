
<h1>零用金支出輸入檢核</h1>
<?php //    CVarDumper::dump($colAry,10,true); ?>
<div class="tableBlue">
<?php echo CHtml::beginForm(); ?>
    <table style="width:50%" >
        <tr>
   
            <td width="30%" >
               年月:
                 <?php
                    echo CHtml::dropDownList('qry_date', $qry_date, $dmAry,array('style'=>'font-size: 18px'));
                 ?>
            </td>

            <td  >
                   <input type="submit" name="fill_qry" value="填寫查詢">
            </td>
            
            <td  >
                   <input type="submit" name="conform_qry" value="金額不符查詢">
            </td>
      
         </tr>
     </table>

</div>   <!-- <div class="tableBlue"> -->

<?php echo CHtml::endForm(); ?>

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>

 <?php if(count($colAry)>0) : ?>
<div class="tableBlue">
    <table>
        <tr>
            <td>
                日期
            </td>
             <td>
               區域
            </td>
             <td>
                門市名稱
            </td>
             <td>
                支出金額
            </td>
        </tr>
         <?php 
            foreach($colAry as $value): 
                echo "<tr>";
                    echo "<td>";
                    echo $value['pdate'];
                    echo "</td>";
                    
                     echo "<td>";
                    echo $value['area'];
                    echo "</td>";
                    
                    echo "<td>";
                    echo $value['storename'];
                    echo "</td>";
                    
                    echo "<td>";
                    echo (float)$value['output'];
                    echo "</td>";
            
                echo "</tr>";
             
          ?>
        
       
        <?php endforeach; ?>
        
    </table>    
</div>
<?php endif; ?>

