
<div class="tableBlue">
<div class="form">
    <?php echo CHtml::beginForm(); ?>
    <table>
        <tr>
      <td>
       
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
      <!-- <td>已讀：<input type="radio" name="isread" value="1"><br>
           未讀：<input type="radio" name="isread" value="2"><br>
           預設：<input type="radio" name="isread" value="0" checked='checked'><br></td>-->
       
         <td>
             <?php  echo CHtml::radioButtonList('isread', $isread, array('1'=>'已讀','2'=>'未讀',''=>'全部'), array('separator' =>' '));  ?> 
         </td>
             
      <td>
     <input type="submit" name="qry" value="查詢">
     </td>
     </table>
<?php echo CHtml::endForm(); ?>
     
</div><!-- form -->
</div>

<div class="tableBlue">          <!--tableBlue -->
    
<?php echo CHtml::beginForm(); ?>
   
       <table >
    
          <tr>
              <td ><?php echo TbaBoard::model()->getAttributeLabel('dates') ;?> </td>
              <td><?php echo TbaBoard::model()->getAttributeLabel('title') ;?> </td>
          </tr>
          
           <?php
       
            for ($i = 0; $i < count($result); $i++) {
               echo "<tr>";
                
                echo "<td td width= 200px>";
                echo $result[$i]['dates'];
                echo "</td>";
                
                echo "<td>";
                 
                echo CHtml::link($result[$i]['read'] ? $result[$i]['title'] :"<b>".$result[$i]['title']."</b>" , //判斷未讀粗體
                        array('tbaBoard/empread?id='.($result[$i]['id'])),
                        array('target'=>'_self')
                    );
                
                echo "</td>";
           
                echo "</tr>";
              
               }
             ?>  
      </table>
      
<?php echo CHtml::endForm(); ?>
      
</div><!-- form -->
  


