
<h1>差勤獎懲結算</h1>


<div class="tableBlue">
<?php echo CHtml::beginForm(); ?>
    <table>
        <tr>
            <td>年月</td>
            <td>
                <input size="10" maxlength="6" name="qry_YM" id="qry_YM" value="<?php echo isset($qry_YM)?$qry_YM:date('Ym'); ?>" type="text" style="font-size: 20px;"/>
            </td>
            <td>員工</td>
            <td>員編:
                <input size="10" maxlength="8" name="qry_empno" id="qry_empno" 
                       value="<?php echo isset($qry_empno)?$qry_empno:''; ?>" type="text" style="font-size: 20px;"/>
                姓名:
                <input size="10" maxlength="10" name="qry_empname" id="qry_empname" 
                       value="<?php echo isset($qry_empname)?$qry_empname:''; ?>" type="text" style="font-size: 20px;"/>
            </td>
            <!--
            <td>顯示差勤：<?php // echo CHtml::checkBox('showTotal',$showTotal); ?></td>
            -->
            <td>功能</td>
            <td>
                <?php echo CHtml::submitButton('畫面輸出', array('name'=>'prt')); ?>
            </td>            
            <td>
                <?php echo CHtml::submitButton('差勤結算', 
                        array('name'=>'settle', 'onclick'=> 'javascript:return showProduceDialog(2);')); ?>
            </td>            
       </tr>
     </table>
<?php echo CHtml::endForm(); ?>
</div>

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo "<div class='flash-$key'>" . $message . "</div>\n";
    }
?> 

<div class="tableBlue">
    <table >
        <tr>
            <?php for ($i = 0; $i < count($col); $i++) : ?>
                <td width="20"><?php echo isset($title[$col[$i]])?$title[$col[$i]]:''; ?></td>
            <?php endfor; ?>
        </tr> 
        
            <?php foreach ($colAry as $empno => $items) : ?>
        <tr>              
                <td><?php echo $empno ; ?></td>                            
                <?php for ($i = 1; $i < count($col); $i++) : ?>
                    <td >
                        <?php if(isset($items[$col[$i]])) echo $items[$col[$i]];  ?>
                    </td>
                <?php endfor; ?>
        </tr>    
            <?php endforeach; ?>
    </table>
</div>

<script>
    // 顯示點擊的訊息
    function showProduceDialog(opt)
    {
        var optmsg = "產製";
        if(opt == 2) optmsg = "結算";
        var daymonth = document.getElementById("qry_YM").value;
        var year = daymonth.substring(0,4);
        var month = daymonth.substring(4,6);        
        var msg =  "確定" + optmsg + year + " 年 " + month + " 月 差勤資料嗎？若該月資料已存在, 將全部刪除！";
        var check = confirm(msg);
        return check;
    }
</script>