 <?php
/* @var $this UserController */
/* @var $model User */

 
?>  
<style>
from{ font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;}
a{color:#666;}
#table{margin:0 auto;background:#333;box-shadow: 5px 5px 5px #888888;border-radius:10px;color:#CCC;padding:10px;}
#table1{margin:0 auto;}
</style>

   <div class="from">  
 
   <?php    $form = $this->beginWidget(
    'CActiveForm',
    array(
        'id' => 'upload-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    )
);
    ?>
           
  <?php     echo $form->labelEx($model,'image');
            echo $form->fileField($model, 'image');
            echo $form->error($model, 'image');
            echo CHtml::submitButton('上傳',array('name'=>'fileUpload'));
            $this->endWidget();
   ?>   
       <?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }  
  
?>
</div> 

<div class="view" id="promotional">
  <div class="item-image">
        
    <?php 
        echo CHtml::image(Yii::app()->request->baseUrl.'/protected/tmp/123.jpg', 'show no picture'); 
        echo "<br>";
        echo CHtml::link("Download Image", array(
        'download'));
    ?>
  </div>
</div>
