<?php 
 echo '<table>';
         echo '<tr>';
         echo '<td>項目</td><td>數項</td>';
         echo '</tr>';
?>
 
<?php  

            $i = 0;//CVarDumper::dump($result,10,true);  
         foreach($result as $key=>$value)
         {
             echo '<tr>';
      
            $item = 'TbaLog'."[$i]".'[item]';
             echo '<td>'.CHtml::textField($item,$value['item'])."</td>";
             $num = 'TbaLog'."[$i]".'[num]';
             echo '<td>'.CHtml::textField($num,$value['num'])."</td>";
             echo '</tr>';
             $i++;
         }
?>



    <?php   echo '</table>'; ?>