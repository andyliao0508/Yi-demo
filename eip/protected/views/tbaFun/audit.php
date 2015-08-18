
<h1>員工差勤異常畫面</h1>
<div class="tableBlue">
    <?php echo CHtml::beginForm(); ?>
    <table>
        <tr>
      <td width="70%" >
       
      日期區間：<?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
             array(
                    'name' => 'qry_dateS',
                    'attribute' => 'qry_dateS',
                    'value'  => $qry_dateS,
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
                  ?>    ~
          <?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
             array(
                    'name' => 'qry_dateE',
                    'attribute' => 'qry_dateE',
                    'value'  => $qry_dateE,
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
      </td>
                
      <td width="30%" >
     <input type="submit" name="qry" value="查詢">
     </td>
     </table>
<?php echo CHtml::endForm(); ?>   
</div>

<div class="tableBlue">
  
    <table>
        <tr>
            <td width="10%">日期</td>
            <td width="15%">門市名稱</td>
            <td width="10%">員工編號</td>
            <td width="10%">員工姓名</td>
            <td width="10%">業績</td>
            <td >差勤情形</td>          
        </tr>
        
        <?php 
        
        if(count($final_result)>0) {                         
            for ($i = 0; $i < count($final_result); $i++) {
                    echo "<tr>"; 
                        echo "<td>".$final_result[$i]['logdate']."</td>"; 
                        echo "<td>".$final_result[$i]['storename']."</td>"; 
                        echo "<td>".$final_result[$i]['empno']."</td>"; 
                        echo "<td>".$final_result[$i]['empname']."</td>";
                        echo "<td>".$final_result[$i]['perform']."</td>";
                        echo "<td>".$final_result[$i]['logname']."</td>";
                    echo "</tr>";                    
                }
        }
        ?>    
    </table>
    
</div>

