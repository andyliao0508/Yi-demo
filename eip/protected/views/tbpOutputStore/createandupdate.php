

<?php if(isset($store) && $pdate!='' && ($isExist==true OR Yii::app()->user->checkAccess('TbpOutputStore.Officecreate'))) : ?>
<h1>門市支出畫面</h1>

<div class="tableBlue">
<?php echo CHtml::beginForm(); ?>
    <!--style="width:35%"-->
 <table > 
        <tr><td>
      顯示:
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
<?php echo CHtml::endForm(); ?>
</div>

<?php $this->renderPartial('_form', array('array'=>$array, 'perform'=>$perform ,'pdate'=>$pdate ,'msg'=>'門市零用金支出')); ?>

<?php else :?>  
 <font size="5" color="red"><b><?php echo $errorMsg; ?></b></font>
<?php endif; ?>
 



