
 <div class="tableBlue" style="width:35%">    
<?php echo CHtml::beginForm(); ?>

     <table >
         <tr>
             <td>請輸入西元年：<input type="text" name="qry_year" value="<?php echo $qry_year; ?>" size="6" maxlength="4" /></td>
              <td>
                    <input type="submit" name="qry" value="查詢">
              </td>
              
              <td>
                   <input type="submit" name="vacation" value="預設假期">
              </td>
             
         </tr>
         
     </table>
        
<?php echo CHtml::endForm(); ?>      
</div>

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>

<?php

if($qry_year!=''){

echo '<table border=0 width=700 style="border: 0px solid black;">';  //style="border: 0px solid black;讓table框線消失
echo '<th colspan=4 align=center style="font-family:Verdana; font-size:18pt; color:#ff9900;">'.$qry_year.'</th>';
for ($reihe=1; $reihe<=3; $reihe++) {
        echo '<tr>';
            for ($spalte=1; $spalte<=4; $spalte++) {
                    $this_month=($reihe-1)*4+$spalte;
                    $erster=date('w',mktime(0,0,0,$this_month,1,$qry_year));
                    $insgesamt=date('t',mktime(0,0,0,$this_month,1,$qry_year));
                    if ($erster==0) $erster=7;
                    echo '<td width="25%" valign=top style="vertical-align:top;">'; // style="vertical-align:top;防止被screen.css的vertical-align:middle影響
                    echo '<table border=0 align=center style="font-size:8pt; font-family:Verdana">';
                    echo '<th colspan=7 align=center style="font-size:12pt; font-family:Arial; color:#666699;">'.$months[$this_month-1].'</th>';
                    echo '<tr><td style="color:#666666"><b>一</b></td><td style="color:#666666"><b>二</b></td>';
                    echo '<td style="color:#666666"><b>三</b></td><td style="color:#666666"><b>四</b></td>';
                    echo '<td style="color:#666666"><b>五</b></td><td style="color:#0000cc"><b>六</b></td>';
                    echo '<td style="color:#cc0000"><b>日</b></td></tr>';
                    echo '<tr><br>';
                    $i=1;
                    while ($i<$erster) {
			echo '<td> </td>';
			$i++;
                    }
                    $i=1;
                    //月份期不足10補0使用
                    if($this_month<10){
                      $this_month= '0'.$this_month;
                      } 
                      
                      while ($i<=$insgesamt) {
			$rest=($i+$erster-1)%7;
                        
                        //日期不足10補0使用
                        if($i<10){
                                $i= '0'.$i;
                            }     
			/*if (($i==$day) && ($this_month==$month)) {
				echo '<td style="font-size:8pt; font-family:Verdana; background:#ff0000;" align=center>';
			} else {*/
                            //判斷資料庫是否有日期 有背景變紅
                             if(in_array("$qry_year$this_month$i", $result)){
                                echo '<td style="font-size:8pt; font-family:Verdana; background:#ff0000;" align=center>';                            
                            }else
                                {
                                echo '<td style="font-size:8pt; font-family:Verdana" align=center>';
                                }				
			//}                 
                          
			/*if (($i==$day) && ($this_month==$month)) {
				echo '<span style="color:#ffffff;">'.$i.'</span>';
			}	else if ($rest==6) {
				echo '<span style="color:#0000cc">'.$i.'</span>';
			} else if ($rest==0) {
				echo '<span style="color:#cc0000">'.$i.'</span>';
			} else {  */
                                
                              /*  if ($rest==6 || $rest==0) {
				echo '<span style="color:#0000cc">'.$i.'</span>';
			}*/
		
                           $holiday = "$qry_year$this_month$i" ;
//                            echo CHtml::link($i,$ur="$qry_year-$this_month-$i");
                             echo CHtml::link($i ,
                                     array('tbaHoliday/holiday?date='.$qry_year.'&update=1&holiday='.$holiday) ,
                                     array('target'=>'_self')
                                 );
                          
			//}
			echo "</td>\n";
			if ($rest==0) echo "</tr>\n<tr>\n";
			$i++;
		}
		echo '</tr>';
		echo '</table>';
		echo '</td>';
    
            }
            echo '</tr>';
}

echo '</table>';

}
?>