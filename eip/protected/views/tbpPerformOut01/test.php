<h1>測試</h1>

<div class="tableBlue">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tbp-perform-out01-form',
	'enableAjaxValidation'=>false,
)); ?>

     <a id="copylink" href="#" rel=".copy">新增</a>
 
    <div class="row copy">
    
<table>
    <tr>    
        <td width="15%">
        <?php
      
  echo CHtml::dropDownList('logtype','',array('1'=>'電費','2'=>'文具','3'=>'文字敘述'),array(
    'empty'=>'----- Type -----',
   // 'id'=>'logtype',
    'ajax'=>array(
        'type'=>'POST',
        'url'=>CController::createUrl('tbpPerformOut01/dynamicemps',array('empty'=>FALSE)),
        //'dataType'=>'json',
//        'data'=>array('logtype'=>'js:this.options[this.selectedIndex].innerHTML'),
//        'success'=>'function(data){
//            $("#opTypeBlock").html(data);
//        }',
         'update'=>'#opTypeBlock', //selector to update
    ),
));       
        
        
        ?>        
        </td>
        
        <td>
            <div id="opTypeBlock">
 
            </div>
        </td>
        
        </tr>
              
</table>
     </div>
<!--    <br>
<div id="opTypeBlock">
 
</div>
    <br>-->
   
<table>    
    <tr>
    <td>
        <?php echo CHtml::submitButton('新增',array('name'=>'create')); ?>
    </td>
    </tr>
	
</table>                

    <?php $this->endWidget(); ?>
</div>

<?php 
$this->widget('ext.jqrelcopy.JQRelcopy',array(
 
 //the id of the 'Copy' link in the view, see below.
 'id' => 'copylink',
 
  //add a icon image tag instead of the text
  //leave empty to disable removing
 //'removeText' => 'Remove',
 
 //htmlOptions of the remove link
 'removeHtmlOptions' => array('style'=>'color:red'),
 
 //options of the plugin, see http://www.andresvidal.com/labs/relcopy.html
 'options' => array(
 
       //A class to attach to each copy
      'copyClass'=>'newcopy',
 
      // The number of allowed copies. Default: 0 is unlimited
      'limit'=>5,
 
      //Option to clear each copies text input fields or textarea
      'clearInputs'=>true,
 
      //A jQuery selector used to exclude an element and its children
      'excludeSelector'=>'.skipcopy',
 
      //Additional HTML to attach at the end of each copy.
      //'append'=>CHtml::tag('span',array('class'=>'hint'),'You can remove this line'),
   )
));