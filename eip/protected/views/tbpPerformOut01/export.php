<h1> 正航報表</h1>
<?php echo '共花費 '.round($computetime,2).' 秒, '; 
    
      echo round(memory_get_usage()/1024/1024,2).' MB, ' ;
         //CVarDumper::dump($cancel_result,10,true);
//        phpinfo();
?><br>

<div class="tableBlue">
<div class="form">
    <?php echo CHtml::beginForm(); ?>
    <table>
        <tr><td>
      區域：
<?php 
    echo CHtml::dropDownList('qry_area',$qry_area, 
                CHtml::listData(
                    TbsArea::model()->findAll(array('order'=>'id ASC','condition'=>'opt1=1')
                ), 'id', 'areaname'),
                array(
                    'prompt'=>'選擇分區',
                    'ajax' => array(
                    'type'=>'POST', //request type
                    'url'=>CController::createUrl('tbpPerformRpt/dynamicstores'), //url to call.
                    //Style: CController::createUrl('currentController/methodToCall')
                    'update'=>'#qry_store', //selector to update
                    //'data'=>'js:javascript statement' 
                    //leave out the data key to pass all form values through
    )));       
?>
      </td>
      <td>
      門市：
<?php
    echo CHtml::dropDownList('qry_store',$qry_store, CHtml::listData(
                TbsStore::model()->findAll(
                        array('order'=>'id ASC','condition'=>'opt1=1')),'storecode', 'storename'),
                        array('empty' => '選擇門市', 'options' => array($qry_store => array('selected' => 'selected')))
            );
?>
      </td>
      
       <td>
       
      區間：<?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
             array(
                    'name' => 'qry_dateS',
                    'attribute' => 'qry_dateS',
                    'value'  => "$qry_dateS",
                    'options'=> array(
                      'dateFormat' =>'yymmdd',
                      'altFormat' =>'yymmdd',
                      'changeMonth' => true,
                      'changeYear' => true,
                    ),
                    'htmlOptions'=>array(
                        'style'=>'width:80px;'
                    ),
                    )); 
                  ?>    ~
          <?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
             array(
                    'name' => 'qry_dateE',
                    'attribute' => 'qry_dateE',
                    'value'  => "$qry_dateE",
                    'options'=> array(
                      'dateFormat' =>'yymmdd',
                      'altFormat' =>'yymmdd',
                      'changeMonth' => true,
                      'changeYear' => true,
                    ),
                    'htmlOptions'=>array(
                        'style'=>'width:80px;'
                    ),
                    )); 
                  ?>    
      </td>
      
        <td>
            <input type="submit" name="qry" value="查詢">
        </td>
        
        <td>
            <input type="submit" name="export" value="匯出正航">
        </td>
        
         <td>
            <input type="submit" name="cancel_export" value="取消匯出">
        </td>
        
        </tr>
    </table>
   
    <table style="width:25%">
         <tr>
             <td>
                <input type="submit" name="qry_move" value="查詢異動">
            </td>
             <td>
                <input type="submit" name="move_export" value="異動表匯出">
            </td>
        </tr>
    </table> 
<?php echo CHtml::endForm(); ?>
</div><!-- form -->
</div>

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo "<div class='flash-$key'>" . $message . "</div>\n";
    } 
?> 


<?php $model = new TbpPerform; ?>
<?php if(isset($fileName) && $fileName!='') : ?>
<div align="center">
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/protected/tmp/<?php echo $fileName; ?>">
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/download01.jpg">
        </a>;
 </div>

<!--$cancel_export 為true -->
<?php elseif($cancel_export) : ?>

<div class="tableBlue">
    <table >
        <tr>
            <td><?php echo $model->getAttributeLabel('pdate')?></td>
            <td><?php echo $model->getAttributeLabel('storename')?></td>
            <td><?php echo $model->getAttributeLabel('total')?></td>
            <td><?php echo $model->getAttributeLabel('output')?></td>
            <td><?php echo $model->getAttributeLabel('remit')?></td>
            <td><?php echo $model->getAttributeLabel('realremit')?></td>
            <td><?php echo $model->getAttributeLabel('realmemo')?></td>
            <td>取消匯出</td>           
        </tr> 
        
         <?php 
        //取消匯出的array
        if(isset($cancel_result) && count($cancel_result)>0) {                         
         
             foreach ($cancel_result as $value1) {
                    echo "<tr>";
                    foreach ($value1 as $value2) {
                       echo "<td> $value2 </td>";
                    }  
                    echo "</tr>";
             }
        }
        ?>    
        
    </table>
</div>

<!--$qry_move 為true -->
<?php elseif($qry_move) : ?>

<div class="tableBlue">
    <table >
        <tr>
            <td><?php echo $model->getAttributeLabel('pdate')?></td>
            <td><?php echo $model->getAttributeLabel('storecode')?></td>
            <td><?php echo $model->getAttributeLabel('storename')?></td>
            <td><?php echo $model->getAttributeLabel('total')?></td>
            <td><?php echo $model->getAttributeLabel('output')?></td>
            <td><?php echo $model->getAttributeLabel('remit')?></td>
            <td><?php echo $model->getAttributeLabel('cemp')?></td>
            <td><?php echo $model->getAttributeLabel('ctime')?></td>
            <td><?php echo $model->getAttributeLabel('uemp')?></td>
            <td><?php echo $model->getAttributeLabel('utime')?></td>                             
        </tr> 
             
        <?php 
        //查詢異動的array
        if(isset($qry_move_result) && count($qry_move_result)>0) {                         
         
             foreach ($qry_move_result as $value1) {
                    echo "<tr>";
                    foreach ($value1 as $value2) {
                       echo "<td> $value2 </td>";
                    }  
                    echo "</tr>";
             }
        }
        ?>
        
    </table>
</div>

<!--正航匯出欄位 -->
<?php else : ?>
<div class="tableBlue">
    <table >
        <tr>
            <?php for ($i = 0; $i < count($col); $i++) : ?>
                <td width="20"><?php echo isset($title[$col[$i]])?$title[$col[$i]]:''; ?></td>
            <?php endfor; ?>
        </tr> 
        
            <?php for ($j = 0; $j < count($colAry); $j++) : ?>
        <tr>              
                 <?php for ($i = 0; $i < count($col); $i++) : ?>
                <td ><?php 
                            if(isset($colAry[$j][$col[$i]]))
                                echo $colAry[$j][$col[$i]]; 
                        ?></td>
                <?php endfor; ?>
        </tr>    
            <?php endfor; ?>
    </table>
</div>
<?php endif; ?>

