<?php
/* @var $this TbpPerformController */
/* @var $dataProvider CActiveDataProvider */

Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
        });
    ");


?>

<h1><?php // echo $user->emp->empname; ?> 期中期末達成率</h1>



<div class="tableBlue">
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
    $stores = array();
    if(isset($qry_area) && $qry_area!='')
        $stores = TbsStore::model()->findAllByAttributes(array(),
                $condition="area_id = '$qry_area' AND opt1=1 ORDER BY id");
    else
        $stores = TbsStore::model()->findAll(array('order'=>'id ASC','condition'=>'opt1=1'));
    
    echo CHtml::dropDownList('qry_store','', CHtml::listData($stores,'storecode', 'storename'),
                        array('empty' => '選擇門市', 'options' => array($qry_store => array('selected' => 'selected')))
            );
?>
      </td>
     
      
      <td>員編：<input  size="10" type="text" name="qry_empno" id="qry_empno" value="<?php echo $qry_empno; ?>"  /></td>
      <td>姓名：<input  size="10" type="text" name="qry_empname" id="qry_empname" value="<?php echo $qry_empname; ?>"  /></td>
      <td>年月：
<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name' => 'qry_date',
    'attribute' => 'qry_date',
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
      <td>顯示期中：<?php echo CHtml::checkBox('check1',$check1); ?><br>
             顯示期末：<?php echo CHtml::checkBox('check2',$check2); ?>            
      
      <td>顯示助理：<input type="checkbox" name="checkAssist" <?php if($checkAssist==1) echo 'checked=true'; ?> ></td>
      
      <td>
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

<?php

    $columnsArray = array();
    $rowsArray = array();
    for ($i = 0; $i < count($col); $i++){
        array_push($columnsArray,$title[$col[$i]]); 
    };

    for ($j = 0; $j < count($colAry); $j++) {
        $row = array();
        for ($i = 0; $i < count($col); $i++) {
            if(isset($colAry[$j][$col[$i]]))
                array_push($row,$colAry[$j][$col[$i]]); 
        }
        array_push($rowsArray, $row);
    }    

$this->widget('ext.htmltableui.htmlTableUi',array(
    'ajaxUrl'=>'',
    'arProvider'=>'',    
    'collapsed'=>false,
    'columns'=>$columnsArray,
    'cssFile'=>'',
    'editable'=>FALSE,
    'enableSort'=>true,
//    'exportUrl'=>'tbpPerformRpt/exportCsv',
//    'extra'=>'匯出EXCEL未實作',
    'footer'=>'資料筆數: '.count($rowsArray).' ',
    'formTitle'=>'rpt09_title',
    'rows'=>$rowsArray,
    'sortColumn'=>2,
    'sortOrder'=>'desc',
    'subtitle'=>'執行時間:'.$computetime.'秒',
    'title'=>'期中期末達成率報表',
));
?>
<!--
<div class="tableBlue">
    <table style=<?php echo 'width: '.(($check1+$check2)>1)?'200%':'100%'; ?> >
        <tr>
            <?php for ($i = 0; $i < count($col); $i++) : ?>
                <td width="20"><?php echo $title[$col[$i]]; ?></td>
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
-->