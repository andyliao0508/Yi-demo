<?php echo CHtml::beginForm(); ?>
<div class="tableBlue">
    <table>
        <tr><td>
      區域：
<?php  
    echo CHtml::dropDownList('qry_area','', 
                CHtml::listData(
                    TbsArea::model()->findAll(array('order'=>'id ASC','condition'=>'opt1=1')
                ), 'id', 'areaname'),
                array(
                    'prompt'=>'選擇分區',                  
                    'ajax' => array(
                    'type'=>'POST', //request type
                    'url'=>CController::createUrl('tbpStore/dynamicstores'), //url to call.
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
    echo CHtml::dropDownList('qry_store','', CHtml::listData(
                TbsStore::model()->findAll(
                        array('order'=>'id ASC','condition'=>'opt1=1')),'storecode', 'storename'),
                        array('empty' => '選擇門市', 'options' => array($qry_store => array('selected' => 'selected')))
            );
?>
      </td>
      
       <td>
          日期：
         
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
            array(
                   'name' => 'qry_date',
                   'attribute' => 'qry_date',
                   'value'  => $qry_date,
                   'options'=> array(
                     'dateFormat' =>'yymmdd',
                     'altFormat' =>'yymmdd',
                     'changeMonth' => true,
                     'changeYear' => true,
                   ),
                   'htmlOptions'=>array(
                       'style'=>'width:100px;'
                   ),
            )); 
       ?>          
      </td>
      
      <td>      <?php echo CHtml::submitButton('查詢', array('name'=>'qry')); ?>     </td>
      
     </table>

</div>   <!-- <div class="tableBlue"> -->


<?php if(isset($store) && count($store)>0 ) : ?>

<div class="tableBlue">

    <!--style="width:35%"-->
 <table > 
        <tr><td>
      預設:
         <input size="5" maxlength="5" name="default_num" id="default_num" 
                    value="<?php echo isset($default_num)?$default_num:''; ?>" type="text" style="font-size: 20px;"/> 筆資料欄位  
        </td>
        
         <td>      <?php echo CHtml::submitButton('更新欄位', array('name'=>'update')); ?>     </td>
         
         <td width=65% >
            <?php
                foreach(Yii::app()->user->getFlashes() as $key => $message) {
                    echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
                }
            ?>
         </td>
        
        </tr>
 </table>
</div>

<!--<div class="tableMultiInput">
    <table style="width:100%;">
        <tr>
            <td width="100">
                <font size="5">門市</font>
            </td>
            <td width="200">
                <font size="5"><?php //echo $store[0]->storename ?></font>
            </td>
            <td width="150">
                <font size="5">支出日期*</font>
            </td>
            <td width="200">
                <font size="5">                           
                <?php //echo $qry_date; ?>
                </font>
            </td>
            <td width="150">
                <font size="5">功能訊息</font>
            </td>
            <td>
                <font size="5">
                <?php
                   // if(isset($msg))  echo $msg;
                ?>
                </font>
            </td>
            
        </tr>
    </table>
</div>-->


<?php $this->renderPartial('_form', array('array'=>$array, 'tbsStroe'=>$store[0] ,'pdate'=>$qry_date ,'msg'=>'管理部零用金支出')); ?>

<?php endif; ?>
<?php echo CHtml::endForm(); ?>