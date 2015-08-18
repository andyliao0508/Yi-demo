<div class="tableBlue">
<?php echo CHtml::beginForm(); ?>
    <table >
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
                    'url'=>CController::createUrl('tbsCom/dynamicstores',array('update'=>'qry_area','empty'=>FALSE)), //url to call.
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
       
       <td >
          年月:
            <?php
               echo CHtml::dropDownList('qry_date', $qry_date, $dmAry,array('style'=>'font-size: 18px'));
            ?>
       </td>
        
         <td width="15%" >
               <input type="submit" name="qry" value="查詢">
         </td>
      
     </table>

</div>   <!-- <div class="tableBlue"> -->

<?php echo CHtml::endForm(); ?>

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>

<div class="tableBlue">
<table>
<tr>    
    <td width="7%">日期</td>
    <td width="7%">主項</td>
    <td width="7%">次項</td>
    <td width="7%">細項</td>
    <td >明細</td>
    <td width="6%">金額</td>
    <td width="24%">備註</td>
    <td width="7%">建立人員</td>  
    <td width="7%">修改人員</td>   
    <td width="7%">操作</td>
</tr>
<?php 
   // CVarDumper::dump($models,10,true);
    // 總金額合計
    $sumTotal = 0; 
?>
<?php foreach($models as $tbpoutput): ?>
<?php foreach($tbpoutput as $k=>$value): ?>

<tr>
    <td>
        <?php echo $value->pdate; ?>       
    </td>
    <td>     
        <?php 
        if(isset($value)){
              $maincname = TbpOutputMain::model()->findByPk($value->mainid);
              if($maincname!=NULL)
                  echo $maincname->cname; 
          }
        ?>
    </td>   
     <td>
         <?php
         if(isset($value)){
              $subcname = TbpOutputSub::model()->findByPk($value->subid);
              if($subcname!=NULL)
                  echo $subcname->cname; 
          }     
         ?>
    </td>
     <td>
         <?php echo $value->itemname; ?>       
    </td>
    <td>
        <?php
        switch($value->type){
         case 1:
             echo ' ';
             break;
         case 2:
             if($value->dates!='' &&$value->datee!='' ){
             echo '日期: '.$value->dates.'～'.$value->datee.', ';
             }
             if($value->num!='' ){
             echo '度數:'.$value->num;
             }
             break;
         case 3:
             echo '數量: '.$value->num;
             break;
         case 4:
             echo $value->num.' 月份';
             break;
        }       
        ?>
    </td>
    
    <td><?php  echo $value->price ?></td>
    
    <td><?php echo $value->memo; ?>
    </td>
   
    <td title="<?php echo $value->cemp!='' &&  $value->ctime!='' ? $value->ctime:''  ?>">
        <?php 
                if(isset($value)){
                    $user = User::model()->findByPk($value->cemp);
                    if($user!=NULL)
                        echo $user->emp->empname; 
                }
            ?>
    </td>
    
    <td title="<?php echo $value->uemp!='' &&  $value->utime!='' ? $value->utime:''  ?>">
        <?php 
          if(isset($value)){
              $user = User::model()->findByPk($value->uemp);
              if($user!=NULL)
                  echo $user->emp->empname; 
          }
      ?>
    </td>
  
     <td>   
         <?php  
            echo CHtml::link('修改',
                        array('tbpOutputStore/createandupdate?storecode='.$value->storecode.'&pdate='.$value->pdate),
                        array('target'=>'_blank')
                    );
        ?>
     </td>       
</tr>
   <?php  $sumTotal = $sumTotal + $value->price; ?>
<?php endforeach; ?>
<?php endforeach; ?>

<tr>  
        <td colspan="4"> </td>
        <td> 合計金額</td>
        <td><?php echo $sumTotal; ?></td>
        <td colspan="4"> </td>
</tr>

</table>
</div>
