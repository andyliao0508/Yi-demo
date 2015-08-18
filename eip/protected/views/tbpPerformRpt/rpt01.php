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
?>

<h1><?php echo $user->emp->empname; ?> 個人業績報表</h1><br>

<?php echo CHtml::beginForm(); ?>
<div class="tableBlue">

    <table >
        <tr>
            <td width="100">達成率</td>
            <td width="150">
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'name' => 'achYm',
                    'attribute' => 'achYm',
                    'value'  => "$achYM",
                    'options'=> array(
                      'dateFormat' =>'yymm',
                      'altFormat' =>'yymm',
                      'changeMonth' => true,
                      'changeYear' => true,
                    ),
                    'htmlOptions'=>array(
                        'style'=>'width:100px;'
                    ),
                  )); 
                ?>
              <!--<input size="10" maxlength="10" name="achYm" id="achYm" value="<?php echo isset($achYM)?$achYM:date('Ym'); ?>" type="text" style="font-size: 20px;"/>-->
            </td>
            <td width="100">
                <input type="submit" name="achieveqry" value="查詢">
            </td>
            <td>
                <?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
            </td>
       </tr>
     </table>

</div>

<div class="tableBlue">
    <table>
        <tr>
            <?php for ($i = 0; $i < count($acol); $i++) : ?>
                <td ><?php echo $atitle[$acol[$i]]; ?></td>
            <?php endfor; ?>
        </tr> 
        
            <?php for ($j = 0; $j < count($colAry); $j++) : ?>
        <tr>              
                 <?php for ($i = 0; $i < count($acol); $i++) : ?>
                <td ><?php 
                            if(isset($colAry[$j][$acol[$i]]))
                                echo $colAry[$j][$acol[$i]]; 
                        ?></td>
                <?php endfor; ?>
        </tr>    
            <?php endfor; ?>
    </table>
</div>

<div class="tableBlue">

    <table>
        <tr>
            <td>業績區間</td>
            <td>起始<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'name' => 'qryStart',
                    'attribute' => 'qryStart',
                    'value'  => "$qryStart",
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
                ?>    ~　結束
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'name' => 'qryEnd',
                    'attribute' => 'qryEnd',
                    'value'  => "$qryEnd",
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
            <td>
                <?php echo CHtml::submitButton('查詢', array('name'=>'qryDates','submit' => Yii::app()->createUrl('tbpPerformRpt/rpt01'))); ?>    
            </td>
        </tr>
    </table>  
</div>
<?php echo CHtml::endForm(); ?>      

<div class="tableBlue">
    
    <div style="display:block;float:left;width:25%">
        
    <table  >
        <tr>
            <td width="50%" >權重</td> <td  width="50%"><?php echo $weight?$weight:0 ?></td> 
        </tr>  
        
    </table>
        
    <table >
        <tr>
           <td >日期</td> <td>差勤獎懲</td> <td>天/分/支</td>
        </tr> 
        
             <?php
            foreach ($attendance as $key1 => $value1) {      
           foreach ($value1 as $key2 => $value2) {
               echo "<tr><td> $key1 </td><td> $key2 </td><td> $value2 </td></tr>";
            }
        }
           ?>
                   
    </table>  
        
    </div>
    
    <div style="display:block;float:left;width:75%">
        
    <table  >
        <tr>
            <?php for ($i = 0; $i < count($col); $i++) : ?>
                <td><?php echo $title[$col[$i]]; ?></td>
            <?php endfor; ?>
        </tr> 
        
            <?php for ($j = 0; $j < count($logArray); $j++) : ?>
        <tr>              
                 <?php for ($i = 0; $i < count($col); $i++) : ?>
                <td ><?php 
                            if(isset($logArray[$j][$col[$i]]))
                                echo $logArray[$j][$col[$i]]; 
                        ?></td>
                <?php endfor; ?>
        </tr>    
            <?php endfor; ?>
        
    </table>
        
    </div>
</div>