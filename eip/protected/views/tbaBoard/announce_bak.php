
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/board.css" />

<div class="tableBlue">          <!--tableBlue -->
    
<?php echo CHtml::beginForm(); ?>

   <!-- <p class="note"><h1>公告區</h1></p>-->
      
       <table class="tableBlue" >
    
          <tr>
              <td width="200px" ><?php echo TbaBoard::model()->getAttributeLabel('dates') ;?> </td>
              <td><?php echo TbaBoard::model()->getAttributeLabel('title') ;?> </td>
          </tr>
          
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
           
           //使用model sql寫法
//           $result = TbaBoard::model()->findAllByAttributes(
//              array(),
//           $conditon = "datee >='$today'   order by datee desc limit $row ");
           
            for ($i = 0; $i < count($result); $i++) {
               echo "<tr>";
                
                echo "<td width= 200px >";
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
      
<?php
//CVarDumper::dump($result,10,true);

/*echo '<br>';
    foreach ($result as $key => $board) {
        echo $board->id;
    }*/
?>
<?php echo CHtml::endForm(); ?>
      
</div><!-- form -->
 
