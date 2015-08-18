 <?php
/* @var $this UserController */
/* @var $model User */

    $this->menu=array(
            array('label'=>'回到公布欄', 'url'=>array('/tbaBoard/boardindex')),
    );
    
?>  
    <style>
    .title{
        font-size: 220%;
        background-color:black;
        color: white;
        font-weight: bold;
      //  font-style:  oblique;  //斜題字
        //  line-height:0.1em;    //行距
    }
    .content{
        font-size: 170%;  
        color: black;
        font-weight: bold;  //文字厚度(中等)
        font-family: impact;
        text-align:left; 
        VERTICAL-ALIGN: text-top;//垂直靠上
        //line-height:0.1em; 
    }
    input[type=submit]{
        background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #ffffff), color-stop(1, #f6f6f6));
        background:-moz-linear-gradient(top, #ffffff 5%, #f6f6f6 100%);
        background:-webkit-linear-gradient(top, #ffffff 5%, #f6f6f6 100%);
        background:-o-linear-gradient(top, #ffffff 5%, #f6f6f6 100%);
        background:-ms-linear-gradient(top, #ffffff 5%, #f6f6f6 100%);
        background:linear-gradient(to bottom, #ffffff 5%, #f6f6f6 100%);
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#f6f6f6',GradientType=0);
        
        background-color:#ffffff;
        
        -moz-border-radius:9px;
        -webkit-border-radius:9px;
        border-radius:9px;
        
        border:2px solid #dcdcdc;
        
        display:inline-block;
        color:#0A0A0A;
        font-family:'新細明體';
        font-size:16px;
        font-weight:normal;
        padding:8px 12px;
        text-decoration:none;
        
        text-shadow:0px 1px 0px #ffffff;
        
         font-weight: bold;
}
input:disabled{
	border: 1px solid #DDD;
	background-color: #F5F5F5;
	color:#ACA899;
        font-weight: bold;
}

    
     </style>      
   <div class="from"> 
       
    <?php echo CHtml::beginForm(); ?>
 
    <table width="100%">
        
        <tr class="title"><th colspan="2">標題:<?php echo $boardcontent_id['title']; ?><th></tr>
     
       <tr >
         
           <td width="430px" height="300px">
           <?php 
            if($boardcontent_id->imagename != '')
            echo CHtml::image($boardcontent_id['imageurl'].$boardcontent_id['imagename'].".".$boardcontent_id['imagetype'], 'show no picture',
                    array("width"=>"350px","height"=>"300px"));
            ?>
           </td>
           
             <td class="content"><br><?php  echo nl2br($boardcontent_id['content']); ?></td>
           
       </tr>
      </table>
       
       </div>

      
      <table>
    <?php
       
      echo "<tr>";
      echo "<td colspan=3 align=center height=70px>";
       
      echo CHtml::link($preEmpty ?'無上一則':'上一則', 'empread?id='.$prerecord ,array('class'=>'preboard','onclick'=>$preEmpty?'return false':'return true',
            'style'=>$preEmpty ? 'color:gray':''), array('target'=>'_self')    //,'style' => $preEmpty ?'display:none': ''
                         );

      echo "&nbsp&nbsp&nbsp&nbsp";
     
    /* if( $readState==true){
          echo CHtml::submitButton('已讀',array('style'=>'width:60px','name'=>'read') );   
     }*/
   
      echo CHtml::submitButton($readState ? '已讀':'未讀',array('style'=>'width:60px','name'=>'read' , 'disabled'=>$readState ) );  //'disabled'=>true   <== 另一種選擇按鈕變灰

      echo "&nbsp&nbsp&nbsp&nbsp";

        /*echo CHtml::link('下一則', 'empread?id='.$nextrecord,array('class'=>'nextboard','style' => $nextEmpty ?'display:none': ''),
                        array('target'=>'_self')
                         );*/

      echo CHtml::link($nextEmpty?'無下一則':'下一則', 'empread?id='.$nextrecord,array('class'=>'nextboard','onclick'=>$nextEmpty?'return false':'return true',
                       'style'=>$nextEmpty ? 'color:gray':'' ),array('target'=>'_self')
                         );

      echo "</td >";
      echo "</tr >";
     ?>   
    </table>
       
    <?php       //show isRead sucess or fail 
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    ?>
    
<?php echo CHtml::endForm(); ?>

     
 
