<?php
 Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/sorttable.js");
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/Report.css" />

<h1>門市業績管理報表</h1>

<?php echo '執行時間:'.round($computetime,2).'秒'; ?>

<div class="tableBlue">
    <?php echo CHtml::beginForm(); ?>
    <table>
        <tr>
            
        <td width="30%">年月：
<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name' => 'qry_date',
    'attribute' => 'qry_date',
    'language' => 'zh-tw',
    'value'  => "$qry_date",
    'options'=> array(
      'dateFormat' =>'yymm',
      'altFormat' =>'yymm',
      'changeMonth' => true,
      'changeYear' => true,
      'yearRange'=>'2013:2015',
    ),
    'htmlOptions'=>array(
        'style'=>'width:100px;'
    ),
  )); 
?>    
        </td>
            
        <td  width="25%">
      區域：
<?php  
  //    echo CHtml::dropDownList('qry_area',$qry_area, 
//                CHtml::listData(
//                    TbsArea::model()->findAll(array('order'=>'id ASC','condition'=>'opt1=1')
//                ), 'id', 'areaname'),
//                array(
//                    'prompt'=>'選擇分區',
//                    'ajax' => array(
//                    'type'=>'POST', //request type
//                    'url'=>CController::createUrl('tbpPerformRpt/dynamicstores'), //url to call.
//                    //Style: CController::createUrl('currentController/methodToCall')
//                    'update'=>'#qry_store', //selector to update
//                    //'data'=>'js:javascript statement' 
//                    //leave out the data key to pass all form values through
//    ))); 
//權限控制
  echo CHtml::dropDownList('qry_area',$qry_area, 
                TbsArea::model()->findByRight(TRUE),
                array(
//                    'prompt'=>'選擇分區',
                    'options' => array($qry_area => array('selected' => 'selected')),
                    'ajax' => array(
                    'type'=>'POST', //request type
                    'url'=>CController::createUrl('tbsCom/dynamicstores',array('update'=>'qry_area')), //url to call.
                    'update'=>'#qry_store', //selector to update
    )));       
?>
        </td>
        <td  width="25%">
      門市：
<?php
    //    $stores = array();
//    if(isset($qry_area) && $qry_area!='')
//        $stores = TbsStore::model()->findAllByAttributes(array(),
//                $condition="area_id = '$qry_area' AND opt1=1 ORDER BY id");
//    else
//        $stores = TbsStore::model()->findAll(array('order'=>'id ASC','condition'=>'opt1=1'));
//    
//    echo CHtml::dropDownList('qry_store','', CHtml::listData($stores,'storecode', 'storename'),
//                        array('empty' => '選擇門市', 'options' => array($qry_store => array('selected' => 'selected')))
//            );
//權限控制
echo CHtml::dropDownList('qry_store',$qry_store, TbsStore::model()->findByRight(TRUE),
                    array( 'prompt'=>'選擇門市','options' => array($qry_store => array('selected' => 'selected')))
            );
?>
        </td>
              
         <td  width="10%">銷售情報：<?php echo CHtml::checkBox('check_sale_Intelligence',$check_sale_Intelligence); ?>
            
         </td>
         
         <td  width="10%">
            <input type="submit" name="qry_daily" value="每日業績">
        </td>
        
        <td  width="10%">
            <input type="submit" name="qry_designer" value="門市設計師">
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

 <?php if($isExist) : ?>

<?php     
        //門市設計師統計用的變數
        $col1 = 0;
        $col2 = 0;
        $col3 = 0;
        $col4 = 0;
        $col5 = 0;
        $col6 = 0;     
        $shampoo = 0;
        $hair_oil = 0;
        $lotion = 0;
        $perform = 0; 
        $assist = 0;
        $rate = 0;

?>

<div class="tableBlue1">
    <table class="sortable" > <!-- class="sortable" style="width:150%" -->
        <thead>
        <tr>
            <?php for ($i = 0; $i < count($col); $i++) : ?>
                <td width="20"><?php echo isset($title[$col[$i]])?$title[$col[$i]]:''; ?></td>
            <?php endfor; ?>
        </tr> 
        </thead>
        
          <?php for ($j = 0; $j < count($colAry); $j++) : ?>
        <tr>              
                 <?php for ($i = 0; $i < count($col); $i++) : ?>
                <td ><?php 
                            if(isset($colAry[$j][$col[$i]])){
                                //連結設計師姓名使用
                                if($col[$i]=='name'){
                                    
                                    echo CHtml::link($colAry[$j][$col[$i]],
                                                array('tbpPerformRpt/rpt01?empno='.$colAry[$j]['empno']),
                                                array('target'=>'_blank')
                                            );      
                                }else{
                                      echo $colAry[$j][$col[$i]]; 
                                }                               
                            }
                        ?></td>
                <?php endfor; ?>
                
                <?php //統計門市設計師選項
                    //剪髮總數
                    $col1 = $col1+$colAry[$j]['col1'];
                    //染髮總數
                    $col2 = $col2+$colAry[$j]['col2'];
                    //助染總數
                    $col3 = $col3+$colAry[$j]['col3'];
                     //優染總數
                    $col4 = $col4+$colAry[$j]['col4'];
                     //優助染總數
                    $col5 = $col5+$colAry[$j]['col5'];
                     //洗髮總數
                    $col6 = $col6+$colAry[$j]['col6'];
                    //洗髮精總數
                    $shampoo = $shampoo+$colAry[$j]['shampoo'];
                    //髮油總數
                    $hair_oil = $hair_oil+$colAry[$j]['hair_oil'];
                    //髮雕總數
                    $lotion = $lotion+$colAry[$j]['lotion'];
                    //業績總數
                    $perform = $perform+$colAry[$j]['perform'];
                    //洗助
                    $assist = $assist+$colAry[$j]['assist'];
                    //總期末達成率       
                    $rate=($rate+$colAry[$j]['rate']);  
                ?>
                
        </tr>    
            <?php endfor; ?>
        
            <?php  //平均期末達成率
            if($rate>0 ){
            $rate=round( $rate / count($colAry),2);
            $rate =  $rate . "%";
           }
            ?> 
        
        <tfoot>
            <tr>
                <?php if($check_sale_Intelligence) : ?>
                
                    <td colspan="7"> </td>
                    <td>合計</td>
                    <td></td>
                    <td><?php echo $col1; ?></td>
                    <td><?php echo $col2; ?></td>
                    <td><?php echo $col3 ?></td>
                    <td><?php echo $col4 ?></td>
                    <td><?php echo $col5; ?></td>
                    <td><?php echo $col6; ?></td>
                    <td><?php echo $shampoo; ?></td>
                    <td><?php echo $hair_oil; ?></td>
                    <td><?php echo $lotion; ?></td>
                    <td><?php echo $perform; ?></td>
                    <td><?php echo $assist; ?></td>
                    <td > 平均達成率</td>
                    <td><?php echo $rate ?  $rate:''; ?></td>
                    <td colspan="6"> </td>
             
                <?php else : ?>
                    <td colspan="7"> </td>
                    <td>合計</td>
                    <td></td>
                    <td><?php echo $perform; ?></td>
                    <td><?php echo $assist; ?></td>
                    <td > 平均達成率</td>
                    <td><?php echo $rate ?  $rate:''; ?></td>
                    <td colspan="6"> </td>
             
                <?php endif; ?>
            </tr>
        </tfoot>
               
    </table>
</div>

 <?php else : ?>
<?php //CVarDumper::dump($colAry3,10,true);
        //統計用的變數
        $col1 = 0;
        $col2 = 0;
        $col3 = 0;
        $col4 = 0;
        $col5 = 0;
        $col6 = 0;
        $col7 = 0;
        $shampoo = 0;
        $moment = 0;
        $isolation = 0;
        $hair_oil = 0;
        $lotion = 0;
        $perform_amount = 0;   
        
        //統計該門市員工銷售情報變數
        $t_col1 = 0;
        $t_col2 = 0;
        $t_col3 = 0;
        $t_col4 = 0;
        $t_col5 = 0;
        $t_col6 = 0;      
        $t_shampoo = 0;
        $t_moment = 0;
        $t_isolation = 0;
        $t_hair_oil = 0;
        $t_lotion = 0;
        $t_perform = 0; 
        $t_rate = 0;  
        
        //占比率變數
        $external=0; //支援人員
        $internal=0; //本店人員
?>

<?php if(count($colAry3)>0) : ?>

<div class="tableBlue1">
    <table class="sortable"> 
        <thead>
            <tr>
            <?php for ($i = 0; $i < count($acol2); $i++) : ?>
                <td width="20"><?php echo isset($atitle2[$acol2[$i]])?$atitle2[$acol2[$i]]:''; ?></td>
            <?php endfor; ?>
            </tr>
        </thead>
                <?php for ($j = 0; $j < count($colAry3); $j++) : ?>
        <tr>              
                 <?php for ($i = 0; $i < count($acol2); $i++) : ?>
                        <td ><?php 
                            if(isset($colAry3[$j][$acol2[$i]])){
                                echo $colAry3[$j][$acol2[$i]];         
                            } 
                            
                             switch ($acol2[$i]){
                                case 'col1' :
                                    $t_col1=$t_col1 + $colAry3[$j][$acol2[$i]] ;
                                    break;
                                case 'col2' :
                                    $t_col2=$t_col2 + $colAry3[$j][$acol2[$i]] ;
                                    break;
                                 case 'col3' :
                                    $t_col3=$t_col3 + $colAry3[$j][$acol2[$i]] ;
                                    break;
                                 case 'col4' :
                                    $t_col4=$t_col4 + $colAry3[$j][$acol2[$i]] ;
                                    break;
                                 case 'col5' :
                                    $t_col5=$t_col5 + $colAry3[$j][$acol2[$i]] ;
                                    break;
                                 case 'col6' :
                                    $t_col6=$t_col6 + $colAry3[$j][$acol2[$i]] ;
                                    break;                                 
                                 case 'shampoo' :
                                    $t_shampoo=$t_shampoo + $colAry3[$j][$acol2[$i]] ;
                                    break; 
                                case 'moment' :
                                    $t_moment=$t_moment + $colAry3[$j][$acol2[$i]] ;
                                    break; 
                                case 'isolation' :
                                    $t_isolation=$t_isolation + $colAry3[$j][$acol2[$i]] ;
                                    break; 
                                case 'hair_oil' :
                                    $t_hair_oil=$t_hair_oil + $colAry3[$j][$acol2[$i]] ;
                                    break; 
                                case 'lotion' :
                                    $t_lotion=$t_lotion + $colAry3[$j][$acol2[$i]] ;
                                    break; 
                                case 'perform' :
                                    $t_perform=$t_perform + $colAry3[$j][$acol2[$i]] ;
                                    break; 
                                case 'rate' :
                                    $t_rate=$t_rate + $colAry3[$j][$acol2[$i]] ;
                                    break;
                                
                            }
                                                    
                              ?></td>
                
                <?php endfor; ?>
                        <?php
                            if($colAry3[$j]['storecode']==$qry_store){
                                 $internal=$internal+$colAry3[$j]['rate'] ;
                            }else {
                                 $external=$external+$colAry3[$j]['rate'] ;
                            }
                        ?>
        </tr>    
            <?php endfor; ?>
        
        <tfoot>
         <tr>          
            <td colspan="6"> </td>
            <td>合計</td> 
            <td> <?php echo $t_col1; ?></td> 
            <td> <?php echo $t_col2; ?></td>
            <td> <?php echo $t_col3; ?></td>
            <td> <?php echo $t_col4; ?></td>
            <td> <?php echo $t_col5; ?></td>
            <td> <?php echo $t_col6; ?></td>          
            <td> <?php echo $t_shampoo; ?></td>
            <td> <?php echo $t_moment; ?></td>
            <td> <?php echo $t_isolation; ?></td>
            <td> <?php echo $t_hair_oil; ?></td>            
            <td> <?php echo $t_lotion; ?></td>
            <td> <?php echo $t_perform; ?></td>
            <td> <?php echo $t_rate ."%"; ?></td>
            <td colspan="1"> </td>
        </tr>
        </tfoot>    
        
    </table>   
</div>
<?php  echo "&nbsp";  ?>
<h3>本店人員業績佔比:<?php echo $internal."%" ?></h3>
<h3>支援人員業績佔比:<?php echo $external."%" ?></h3>
<h3><?php                       // CVarDumper::dump($other,10,true);
    if(isset($other['rate']) && isset($other['item'])){
    echo '其他項目佔比:'.$other['rate'].'， 項目:'.$other['item'];
    }
    if(isset($other['rate2']) && isset($other['item2'])){ 
        echo '<br>優待票佔比:'.$other['rate2'].'， 項目:'.$other['item2'];
    }
    ?>
</h3>
<hr>

<?php endif; ?>

<?php if(count($colAry2)>0) : ?>
<div class="tableBlue">
    <table > 
       
        <tr>
            <?php for ($i = 0; $i < count($acol); $i++) : ?>
                <td width="20"><?php echo isset($atitle[$acol[$i]])?$atitle[$acol[$i]]:''; ?></td>
            <?php endfor; ?>
        </tr>        
        
          <?php for ($j = 0; $j < count($colAry2); $j++) : ?>
        <tr>              
                 <?php for ($i = 0; $i < count($acol); $i++) : ?>
                <td ><?php 
                            if(isset($colAry2[$j][$acol[$i]])){
                                echo $colAry2[$j][$acol[$i]];         
                            }
                            switch ($acol[$i]){
                                case 'col1' :
                                    $col1=$col1 + $colAry2[$j][$acol[$i]] ;
                                    break;
                                case 'col2' :
                                    $col2=$col2 + $colAry2[$j][$acol[$i]] ;
                                    break;
                                case 'col3' :
                                   $col3=$col3 + $colAry2[$j][$acol[$i]] ;
                                   break;
                                case 'col4' :
                                   $col4=$col4 + $colAry2[$j][$acol[$i]] ;
                                   break;
                                case 'col5' :
                                   $col5=$col5 + $colAry2[$j][$acol[$i]] ;
                                   break;
                                case 'col6' :
                                   $col6=$col6 + $colAry2[$j][$acol[$i]] ;
                                   break;
                                case 'col7' :
                                   $col7=$col7 + $colAry2[$j][$acol[$i]] ;
                                   break;
                                case 'shampoo' :
                                   $shampoo=$shampoo + $colAry2[$j][$acol[$i]] ;
                                   break;
                                case 'moment' :
                                   $moment=$moment + $colAry2[$j][$acol[$i]] ;
                                    break; 
                                case 'isolation' :
                                    $isolation=$isolation + $colAry2[$j][$acol[$i]] ;
                                    break; 
                                case 'hair_oil' :
                                    $hair_oil=$hair_oil + $colAry2[$j][$acol[$i]] ;
                                    break; 
                                case 'lotion' :
                                    $lotion=$lotion + $colAry2[$j][$acol[$i]] ;
                                    break; 
                                case 'perform_amount' :
                                    $perform_amount=$perform_amount + $colAry2[$j][$acol[$i]] ;
                                    break; 
                            }
                        ?></td>
                
                <?php endfor; ?>
        </tr>    
            <?php endfor; ?>
        
        <tr>          
        <td> 總合計</td> 
        <td> <?php echo $col1; ?></td> 
        <td> <?php echo $col2; ?></td>
        <td> <?php echo $col3; ?></td>
        <td> <?php echo $col4; ?></td>
        <td> <?php echo $col5; ?></td>
        <td> <?php echo $col6; ?></td>
        <td> <?php echo $col7; ?></td>
        <td> <?php echo $shampoo; ?></td>
        <td> <?php echo $moment; ?></td>
        <td> <?php echo $isolation; ?></td>
        <td> <?php echo $hair_oil; ?></td>
        <td> <?php echo $lotion; ?></td>
        <td> <?php echo $perform_amount; ?></td>
        </tr>
          
    </table>
</div>
<?php endif; ?>

<?php endif; ?>
  