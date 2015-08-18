<?php
 Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/sorttable.js");  
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/Report.css" />

<h1>區域業績管理報表</h1>

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
            
        <td width="25%">
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
        <td width="25%">
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
                    array('prompt'=>'選擇門市','options' => array($qry_store => array('selected' => 'selected')))
            );

?>
        </td>
        
        <td  width="10%">銷售情報：<?php echo CHtml::checkBox('check_area',$check_area); ?>

        </td>
        
        <td width="10%">
       <input type="submit" name="qry" value="查詢">
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
                                //連結門市業績使用
                                if($col[$i]=='store'){
                                    
                                    echo CHtml::link($colAry[$j][$col[$i]],
                                                array('tbpPerformRpt/rpt11?storecode='.$colAry[$j]['storecode'].'&pdate='.$qry_date),
                                                array('target'=>'_blank')
                                            );      
                                }else{
                                      echo $colAry[$j][$col[$i]]; 
                                }
                            }
                        ?></td>
                <?php endfor; ?>
        </tr>    
            <?php endfor; ?>
              
    </table>
</div>

  