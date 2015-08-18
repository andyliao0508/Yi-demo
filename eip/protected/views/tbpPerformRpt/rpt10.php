<?php
/* @var $this TbpPerformController */
/* @var $dataProvider CActiveDataProvider */
?>


<h1>業績月報表</h1>

<div class="tableBlue">
<div class="form">
    <?php echo CHtml::beginForm(); ?>
    <table >
        <tr>
            <td width="50">
                年月
            </td >
            <td width="120">
                <?php
                    echo CHtml::dropDownList('qry_date', $qry_date, $dmAry,array('style'=>'font-size: 18px'));
                ?>
            </td>            
            <td width="50">
                功能
            </td>
      <td width="150">
        <input type="submit" name="qry" value="業績查詢">
     </td>
     <td >
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>         
     </td>
</tr>  
     </table>
<?php echo CHtml::endForm(); ?>
</div><!-- form -->    
</div>


<!-- 月報表中, 每逢六日要用紅色顯示-->
<div class="tableMonth">
    <table >
        
        <thead>
            <tr>
                <th width="100"><?php echo isset($title[$col[0]])?$title[$col[0]]:''; ?></th>
                <th width="100"><?php echo isset($title[$col[1]])?$title[$col[1]]:''; ?></th>
                <?php 
                    $date_ym = $qry_date;
                    
                    for ($i = 2; $i < count($col)-1; $i++) {
                        $date_d = $col[$i];
                        $show_date = $date_ym.$date_d;
                        $w = date('w',strtotime($show_date));
                        if($w == 6 OR $w == 0) 
                            echo "<th bgcolor=red>";
                        else
                            echo "<th>";

                        echo isset($title[$col[$i]])?$title[$col[$i]]:'';
                        echo "</th>";
                    }
                ?>
                <th ><?php echo isset($title[$col[count($col)-1]])?$title[$col[$i]]:''; ?></th>
            </tr>         
        </thead>      
        
        <tbody>
            <?php 
                // 分區, 每一區都顯示一下標題列
                $area = '北一區';
                $tbsArea = TbsArea::model()->findAll();
                if($tbsArea!=null && count($tbsArea)>0)
                    $area = $tbsArea[0]->areaname;
                
                $chgColor = 1;
                $chgBgColor = '#FDFF73';
                foreach ($colAry as $key => $value) : 
                    if(isset($colAry[$key][$col[0]]))
                        if($colAry[$key][$col[0]] == $area) :
            ?>
            <tr>              
                <?php 
                    for ($i = 0; $i < count($col); $i++) {
                        if(isset($colAry[$key][$col[$i]]) && $colAry[$key][$col[$i]] != '') {
                            if($chgColor%5 == 0)
                                echo "<td bgcolor='$chgBgColor'>".$colAry[$key][$col[$i]]."</td>";
                            else
                                echo "<td>".$colAry[$key][$col[$i]]."</td>";
                        }
                        else
                            echo "<td bgcolor=grey> </td>";
                    }
                ?>
            </tr>
        </tbody>
        <?php
                    else :
        ?>
            <thead>
                    <tr>
                        <th width="100"><?php echo isset($title[$col[0]])?$title[$col[0]]:''; ?></th>
                        <th width="100"><?php echo isset($title[$col[1]])?$title[$col[1]]:''; ?></th>
                        <?php 
                            $chgColor = 1;
                            $date_ym = $qry_date;
                            for ($i = 2; $i < count($col)-1; $i++) {
                                $date_d = $col[$i];
                                $show_date = $date_ym.$date_d;
                                $w = date('w',strtotime($show_date));
                                if($w == 6 OR $w == 0) 
                                    echo "<th bgcolor=red>";
                                else
                                    echo "<th>";

                                echo isset($title[$col[$i]])?$title[$col[$i]]:'';
                                echo "</th>";
                            }
                        ?>
                        <th ><?php echo isset($title[$col[count($col)-1]])?$title[$col[$i]]:''; ?></th>
                    </tr>         
            </thead>                                        
            <tbody>
                    <tr>              
                    <!--<td >-->
                        <?php 
                            if(isset($colAry[$key][$col[0]])) {
                                $area = $colAry[$key][$col[0]];
                            }
                        ?>
                    <?php 
                        for ($i = 0; $i < count($col); $i++) {
                            if(isset($colAry[$key][$col[$i]]) && $colAry[$key][$col[$i]] != '') {
                                if($chgColor%5 == 0)
                                    echo "<td bgcolor='$chgBgColor'>".$colAry[$key][$col[$i]]."</td>";
                                else
                                    echo "<td>".$colAry[$key][$col[$i]]."</td>";
                            }
                            else
                                echo "<td bgcolor=grey> </td>";
                        }
                    ?>
                    </tr>
            </tbody>
        <?php 
                endif;
                
                $chgColor ++ ;
            endforeach; 
        ?>
        
    </table>
</div>