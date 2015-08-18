<?php
/* @var $this TbpOutputStoreController */
/* @var $model TbpOutputStore */
/* @var $form CActiveForm */
?>



<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tbp-outputstore-form',
	'enableAjaxValidation'=>false,
     
)); 

?>
<!--    <font size="4" color="red">
        <?php //echo $form->errorSummary($model, '零用金, 請修正以下錯誤！'); ?>
    </font>-->

<?php
//    foreach(Yii::app()->user->getFlashes() as $key => $message) {
//        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
//    }
?>

<div class="tableMultiInput">
    <font size="5">
    <table style="width:100%;">
        <tr>
            <td width="80" >門市</td>
            <td width="200"><?php echo $perform->storename; ?></td>
            <td width="100">支出日期</td>
            <td width="100"><?php echo $perform->pdate; ?></td>
            <td width="100">支出金額</td>
            <td width="100"><?php echo $perform->output; ?></td>
            <td width="80" >訊息</td>
            <td><?php  if(isset($msg))  echo $msg;  ?></td>
        </tr>
    </table>
    </font>
    
    <table>
        <tr >
            <td width="5%" height="40">
                <b>編號</b>
            </td>
            <td width="7%">主項</td>
            <td width="7%">次項</td>
            <td width="7%">細項</td>
            <!--<td width="5%">類型</td>-->
                     
            <td>零用金明細</td>
            <td width="4%">金額</td>
            <td width="18%">備註</td>
            <td width="6%">建立人員</td>
            <!--<td width="7%">建立時間</td>-->
            <td width="6%">修改人員</td>
            <!--<td width="7%">修改時間</td>-->
            <?php
              if(Yii::app()->user->checkAccess('TbpOutputStore.Officecreate')) : ?>
            <td width="8%">操作</td>
            <?php else :?>
            <td width="8%">刪除</td>
            <?php endif; ?>  
            
        </tr>
        
    <?php for ($i = 0; $i < count($array); $i++) : ?>

        <tr>
            <td height="30"><?php echo $i+1; ?></td>
             <td>
                <?php
                    echo  CHtml::dropDownList('TbpOutputLog['.$i.'][mainid]',$array[$i]->mainid, 
                                CHtml::listData(TbpOutputMain::model()->findAll(array('order' => 'id ASC','condition'=>'opt1=1')), 'id', 'cname'),
                                array(
                                    "disabled"=>$array[$i]->opt1==0?"disabled" :'', //以opt1判斷是否disable
                                    'prompt'=>'選擇主項',
                                    'options' => array($array[$i]->mainid => array('selected' => 'selected')),
                                    'ajax' => array(
                                    'type'=>'POST', //request type
                                    'url'=>CController::createUrl('tbpOutputStore/dynamicoutputsubs',array('index'=>$i)), //url to call.
                                    //Style: CController::createUrl('currentController/methodToCall')
                                    'update'=>'#TbpOutputLog_'.$i.'_subid', //selector to update 
                                    //'data'=>'js:javascript statement' 
                                    //leave out the data key to pass all form values through
                    )));       
                ?> 
            </td>
            
            <td>
                <?php
                    echo CHtml::dropDownList('TbpOutputLog['.$i.'][subid]',$array[$i]->subid,
                            CHtml::listData(TbpOutputSub::model()->findallByAttributes(array('id'=>$array[$i]->subid? $array[$i]->subid:'')), 'id', 'cname'),//如果是空就不要帶入次項畫面
                           // array(),
                                        array(
                                            "disabled"=>$array[$i]->opt1==0?"disabled" :'', //以opt1判斷是否disable
                                          //  'prompt' => '--選擇次項--',
                                            'options' => array($array[$i]->subid => array('selected' => 'selected')),
                                            'ajax' => array(
                                            'type'=>'POST', //request type
                                            'url'=>CController::createUrl('tbpOutputStore/dynamicoutputitems',array('index'=>$i)), //url to call.
                                            //Style: CController::createUrl('currentController/methodToCall')
                                            'update'=>'#TbpOutputLog_'.$i.'_itemid', //selector to update 
                                            //'data'=>'js:javascript statement' 
                                            //leave out the data key to pass all form values through
                    )));                 
                ?>         
            </td>
            
            <td>
                <?php
                    echo CHtml::dropDownList('TbpOutputLog['.$i.'][itemid]',$array[$i]->itemid,
                            CHtml::listData( TbpOutputItem::model()->findallByAttributes(array('id'=>$array[$i]->itemid? $array[$i]->itemid:'')), 'id', 'cname'),//如果是空就不要帶入細項畫面
                           // CHtml::listData( TbpOutputItem::model()->findAll(array('order'=>'id ASC','condition'=>'opt1=1')), 'id', 'cname'),
                           // array(),
                                        array(
                                            "disabled"=>$array[$i]->opt1==0?"disabled" :'', //以opt1判斷是否disable
                                             //  'prompt'=>'選擇細項',
                                               'options' => array($array[$i]->itemid => array('selected' => 'selected')),
                                               'ajax' => array(
                                               'url'=>CController::createUrl('tbpOutputStore/dynamictype',array('index'=>$i)), //url to call.
                                               //Style: CController::createUrl('currentController/methodToCall')
                                               //'update'=>'#opTypeBlock'.$i, //selector to update 
                                               //'data'=>'js:javascript statement' 
                                              'data'=>array('TbpOutputLog['.$i.'][itemid]'=>'js:this.value'),
                                               'success'=>'function(data){
                                                   $("#opTypeBlock'.$i.'").html(data);
                                               }',
                                               //leave out the data key to pass all form values through
                                            )));       
                ?>
            </td>
            <!--<td>-->
                
                <input type="hidden" name=<?php echo "TbpOutputLog[$i][id]" ?> value="<?php echo $array[$i]->id; ?>" />             
            <?php           
//                    echo CHtml::dropDownList('TbpOutputLog['.$i.'][type]',$array[$i]->type,array('1'=>'type1','2'=>'type2','3'=>'type3'),array(
//                      'empty'=>'-類型-',
//                      //'id'=>'logtype',
//                      'ajax'=>array(
//                          'type'=>'POST',
//                              'url'=>CController::createUrl('tbpOutputStore/dynamicemps',array('index'=>$i)),
//                          //'dataType'=>'json',
//                  //        'data'=>array('logtype'=>'js:this.options[this.selectedIndex].innerHTML'),
//                  //        'success'=>'function(data){
//                  //            $("#opTypeBlock").html(data);
//                  //        }',
//                           'update'=>'#opTypeBlock'.$i, //selector to update
//                      ),
//                  ));      
            ?>
            <!--</td>-->               
            <td>
                     <div id='<?php echo "opTypeBlock".$i; ?>' align='left'>
                        <?php if(isset($array[$i]) && $array[$i]->type != '') 
                                $this->renderPartial('_type'.$array[$i]->type,array('model'=>$array[$i],'row'=>$i)); 
                            ?>
                    </div>
            </td>
            
            <td>
                 <?php 
                    if(isset($array[$i])){
                       echo CHtml::activeTextField($array[$i],"[$i]price",array('maxlength'=>8 ,'size'=>4 , "disabled"=>$array[$i]->opt1==0?"disabled" :'',));
                    }
                 ?>
            </td>
            
            <td>
                 <?php 
                    if(isset($array[$i])){
                       echo CHtml::activeTextArea($array[$i],"[$i]memo",array('rows'=>2, 'cols'=>4,'style'=>'width:90%', "disabled"=>$array[$i]->opt1==0?"disabled" :'',));
                    }
                 ?>
            </td>
                     
            <td>
                <div id="cempBlock" title="<?php  echo isset($array[$i])  && $array[$i]->type != '' && $array[$i]->ctime != ''? $array[$i]->ctime: '' ?>" >
                       <?php if(isset($array[$i])   && $array[$i]->type != '' && $array[$i]->cemp != ''){
                                $user = User::model()->findByPk($array[$i]->cemp);
                                if($user!=NULL)
                                    echo $user->emp->empname;                               
                             }
                        ?>
                        <input type="hidden" name=<?php echo "TbpOutputLog[$i][cemp]" ?> value="<?php echo $array[$i]->cemp; ?>" />
                    </div>               
            </td>
            <!--<td>-->
                    <!--<div id="ctimeBlock">-->
                       <?php 
//                       if(isset($array[$i])   && $array[$i]->type != '' && $array[$i]->ctime != ''){
//                                echo $array[$i]->ctime;                            
//                             }
                        ?>
                        <input type="hidden" name=<?php echo "TbpOutputLog[$i][ctime]" ?> value="<?php echo $array[$i]->ctime; ?>" />
                    <!--</div>-->               
            <!--</td>-->
            <td>
                    <div id="uempBlock" title="<?php  echo isset($array[$i])  && $array[$i]->type != '' && $array[$i]->utime != ''? $array[$i]->utime: '' ?>">
                        <?php if(isset($array[$i])  && $array[$i]->type != '' && $array[$i]->uemp != ''){
                                $user = User::model()->findByPk($array[$i]->uemp);
                                if($user!=NULL)
                                    echo $user->emp->empname;
                                // echo $array[$i]->uemp;
                              }                             
                        ?>
                        <input type="hidden" name=<?php echo "TbpOutputLog[$i][uemp]" ?> value="<?php echo $array[$i]->uemp; ?>" />
                    </div>               
            </td>
<!--             <td>
                    <div id="utimeBlock">-->
                       <?php 
//                       if(isset($array[$i])   && $array[$i]->type != '' && $array[$i]->utime != '') : 
//                                echo $array[$i]->utime;                            
                        ?>
                        <input type="hidden" name=<?php echo "TbpOutputLog[$i][utime]" ?> value="<?php echo $array[$i]->utime; ?>" />
                        <?php // endif; ?>
<!--                    </div>               
            </td>-->
            <td>
                    <div id="operationBlock" style="white-space:nowrap"> <!-- style="white-space:nowrap" 讓DIV內容不換行 -->
                         <?php  
                        // 若有修改刪除與取消刪除支出明細的權限, 才顯示下面功能
                        if(Yii::app()->user->checkAccess('TbpOutputStore.Officecreate') &&  $array[$i]->type != '') : ?>
                                                
                            <?php 
                            if($array[$i]->opt1 == 1)
                            echo CHtml::submitButton('刪除', array('name'=>$i.'delete'));
                            elseif($array[$i]->opt1 ==0)
                            echo CHtml::submitButton('取消刪除', array('name'=>$i.'cancel_del')); 
                            ?>
                        <?php elseif(!Yii::app()->user->checkAccess('TbpOutputStore.Officecreate') &&  $array[$i]->type != '') : ?>
                            
                            <?php 
                            if($array[$i]->opt1 == 1)
                            echo '';
                            elseif($array[$i]->opt1 ==0)
                            echo    "<font size='4' color='red' >已刪除</font>"; 
                            ?>                      
                         <?php endif; ?>  
                    </div>               
            </td>
            
        </tr>
    <?php endfor; ?>        
    </table>    
</div>    
    
<div class="tableMultiInput">
    <table>
        <tr>
            <td>
                <?php echo CHtml::submitButton('填完送出', 
                        array('style'=>"width:200px", 'name'=>'send')); ?>
                <?php echo CHtml::submitButton('重新載入', 
                        array('style'=>"width:200px", 'name'=>'reload')); ?>
            </td>
        </tr>
    </table>
</div>    

<?php $this->endWidget(); ?>

