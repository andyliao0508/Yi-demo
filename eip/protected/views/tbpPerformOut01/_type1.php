<?php 
 echo '<table>';
         echo '<tr>';
         echo '<td>日期開始</td><td>日期結束</td><td>度數</td><td>價錢</td>';
         echo '</tr>';
?>

<?php 

// echo '<tr>';
// echo '<td>';
//$this->widget('zii.widgets.jui.CJuiDatePicker',array(
//    'name'=>'logday',
//    'attribute' => 'logday',
//     'value'  => "",
//    'options'=>array(
//        'showAnim'=>'fold',
//        'changeMonth'=>true,
//        'changeYear'=>true,
//        'dateFormat' => 'yymmdd',
//    ),
//    'model'=>$model,
//    'htmlOptions'=>array(
//    'style'=>'width:100px;',
//    ),
//));
// echo '</td>';
// echo '<td>';
?>
 
<?php  
//    $this->widget('zii.widgets.jui.CJuiDatePicker',array(
//    'name'=>'ctime',
//    'attribute' => 'ctime',
//     'value'  => "",
//    'options'=>array(
//        'showAnim'=>'fold',
//        'changeMonth'=>true,
//        'changeYear'=>true,
//        'dateFormat' => 'yymmdd',
//    ),
//    'model'=>$model,
//    'htmlOptions'=>array(
//    'style'=>'width:100px;',
//    ),
//));
// echo '</td>';
// echo '</tr>';
            $i = 0;//CVarDumper::dump($result,10,true);  
         foreach($result as $key=>$value)
         {
             echo '<tr>';
             echo '<td>';
            $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                'name'=>'TbaLog'."[$i]".'[logday]',
                'attribute' => 'logday',
                 'value'  =>$value['logday'],
                'options'=>array(
                    'showAnim'=>'fold',
                    'changeMonth'=>true,
                    'changeYear'=>true,
                    'dateFormat' => 'yymmdd',
                ),
              //  'model'=>$model,
                'htmlOptions'=>array(
                'style'=>'width:100px;',
                ),
            ));
            echo '</td>';
            
             echo '<td>';
            $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                'name'=>'TbaLog'."[$i]".'[ctime]',
                'attribute' => 'ctime',
                 'value'  =>$value['ctime'],
                'options'=>array(
                    'showAnim'=>'fold',
                    'changeMonth'=>true,
                    'changeYear'=>true,
                    'dateFormat' => 'yymmdd',
                ),
              //  'model'=>$model,
                'htmlOptions'=>array(
                'style'=>'width:100px;',
                ),
            ));
            echo '</td>';

            $num = 'TbaLog'."[$i]".'[num]';
             echo '<td>'.CHtml::textField($num,$value['num'])."</td>";
             $price = 'TbaLog'."[$i]".'[price]';
             echo '<td>'.CHtml::textField($price,'')."</td>";
             echo '</tr>';
             $i++;
         }
?>



    <?php   echo '</table>'; ?>