<?php
/* @var $this TbpPerformController */
/* @var $dataProvider CActiveDataProvider */

//$this->breadcrumbs=array(
//	'Tbp Performs',
//);

//$this->menu=array(
//	array('label'=>'Create TbpPerform', 'url'=>array('create')),
//	array('label'=>'Manage TbpPerform', 'url'=>array('admin')),
//);

//    ini_set('memory_limit', '4096M');
    
    Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
        });
    ");
?>

<h1><?php // echo $user->emp->empname; ?> 報表</h1>
    <?php echo '共花費 '.round($computetime,2).' 秒, '; 
    
        echo round(memory_get_usage()/1024/1024,2).' MB, ' ;
        
//        phpinfo();
    ?><br>

<div class="tableBlue">
<div class="form">
    <?php echo CHtml::beginForm(); ?>
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
    echo CHtml::dropDownList('qry_store','', CHtml::listData(
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
      <td>員編
      <td>
      <input  size="10" type="text" name="qry_empno" id="qry_empno" value="<?php echo $qry_empno; ?>"  />
      </td>
      <td>姓名</td>
      <td>
      <input  size="10" type="text" name="qry_empname" id="qry_empname" value="<?php echo $qry_empname; ?>"  />
      </td>
      
      <td>
     <input type="submit" name="qry" value="每日報表查詢">
     </td>
     <td>
     <input type="submit" name="qry2" value="合併日期查詢">
     </td>
</tr>
<tr>
    <td>報表類型:<?php
                        echo CHtml::dropDownList('rpttype','', 
                                    CHtml::listData(
                                        TbpPerformParamRpt08Type::model()->findAll(array('order'=>'id ASC','condition'=>'opt1=1')
                                    ), 'id', 'rpttype'),
                                    array(
                                        'prompt'=>'選擇種類',
                                        'ajax' => array(
                                        'type'=>'POST', //request type
                                        'url'=>CController::createUrl('tbpPerformRpt/dynamicrptname'), //url to call.
                                        //Style: CController::createUrl('currentController/methodToCall')
                                        'update'=>'#rptname', //selector to update
                                        //'data'=>'js:javascript statement' 
                                        //leave out the data key to pass all form values through
                        )));       
                    ?></td>
    <td>報表名稱:<?php
    echo CHtml::dropDownList('rptname','', CHtml::listData(
                                            TbpPerformParamRpt08Name::model()->findAll(
                                                array('order'=>'id ASC','condition'=>'opt1=1')),'id', 'rptname'),
                                                array('empty' => '選擇名稱', 'options' => array($rptname => array('selected' => 'selected')))
                                    );
                        ?></td>
    <td colspan="7">
        <?php echo CHtml::htmlButton('篩選條件',array('class'=>'search-button')); ?>
      </td>
</tr>
    
     </table>

     



<div class="search-form" style="display:none">
<?php 
    if(isset($serviceary))
        echo CHtml::checkBoxList('qry_serviceno',  $qry_serviceno, $serviceary,
                            array('checkAll'=>'全選','separator'=>' ','template'=>'<div>{input}&nbsp;{label}</div>')
                        ); 
?>
</div><!-- search-form -->    

<?php echo CHtml::endForm(); ?>
</div><!-- form -->
</div>
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