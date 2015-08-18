<?php 
 echo '<table>';
         echo '<tr>';
         echo '<td>敘述</td>';
         echo '</tr>';
?>

<?php  

            $i = 0;//CVarDumper::dump($result,10,true);  
         foreach($result as $key=>$value)
         {
                      
             $memo = 'TbaLog'."[$i]".'[memo]';
             echo '<td>'.CHtml::textArea($memo,$value['memo'])."</td>";
             echo '</tr>';
             $i++;
         }
?>



    <?php   echo '</table>'; ?>