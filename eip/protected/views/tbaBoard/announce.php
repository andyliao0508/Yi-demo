
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/example.css" />

<div class="announe">          <!--tableBlue -->
     
<?php echo CHtml::beginForm(); ?>

       <table >
           <tr>
               <td>　　
                   <table >
                     
                       <?php
           
                        $row_num = TbaParam::model()->findByAttributes(array('param'=>'board_num'));//取sql值時,先取得變數代碼等於 'select * from tba_param where param = board_num'
                        $row = $row_num->pvalue;  //取的變數內容;

                        //直接從Contraller的actionAnnounce移過來   

                        $today=date('Y-m-d'); //今天日期

                        //使用sql寫法
                        $sql = "SELECT a.id, a.title, a.content, a.dates, b.read FROM
                               (SELECT * FROM `tba_board` WHERE datee >='$today' ) a LEFT JOIN `tba_board_emp_log` b
                               ON a.id = b.board_id order by datee desc limit $row";
                        $result = Yii::app()->db->createCommand($sql)->queryAll();   

                         for ($i = 0; $i < count($result); $i++) {
                             echo "<tr>";
                             echo "<td>";

                             echo "<b>#-</b> ". CHtml::link($result[$i]['read'] ? $result[$i]['title'] :"<b>".$result[$i]['title']."</b>" , //判斷未讀粗體
                                     array('tbaBoard/empread?id='.($result[$i]['id'])),
                                     array('target'=>'_self')
                                 );

                             echo "</td>";
                             echo "</tr>";

                            }
                          ?>  
                       
                   </table>
               </td>
               
               <td >
                    <?php 
                    
                        $homepicture = TbaBoard::model()->findByAttributes( array(),
                            $conditon = " datee >='$today'and opt3 = 1 order by datee desc"
                            );
                            if( $homepicture ){
                               
                                echo CHtml::image(Yii::app()->request->baseUrl.$homepicture->imageurl.'.'.$homepicture->imagetype, 'show no picture',
                                     array("width"=>"350px","height"=>"280px"));
                            }
                    ?>
                   
               </td>
           </tr>
        </table>
    
    
                
    

<?php echo CHtml::endForm(); ?>
      
</div><!--tableBlue -->
