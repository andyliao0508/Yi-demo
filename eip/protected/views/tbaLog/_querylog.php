<script type='text/javascript'>

jQuery('#tba-log-grid a.for-leave-prove-class').live('click',function() {
        if(!confirm('你確定要執行此動作?')) return false;
       
        var url = $(this).attr('href');
        //  do your post request here
        $.post(url,function(){    
//             alert(res);
          $.fn.yiiGridView.update('tba-log-grid');
             //  afterDelete(th,true,data);                  
                           
         });
       // $('#tba-log-grid').yiiGridView('update', {
	//	data: $(this).serialize()
	//});
        return false;
});

</script>

<?php 

    $bg1 = 'background:YELLOW';
    $bg2 = 'background:GREEN';
    $bg3 = 'background:RED';
    $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tba-log-grid',
	'dataProvider'=>$model->search(),
                   'filter'=>$model,
	'columns'=>array(
//                        'id',
                        array(
                            'name'=>'logday',
                            'value'=>'Yii::app()->dateFormatter->format("y-MM-dd",strtotime($data->logday))'
                        ),       
                        'storename',
                        'empname',
                        'logname',
                        array(
                            'name'=>'num',
                            'value'=>'Yii::app()->NumberFormatter->format("##.#",$data->num)'
                        ),       
                        'memo',
                        'cemp',
                        array(
                            'name'=>'ctime',
                            'value'=>'Yii::app()->dateFormatter->format("y-MM-dd",strtotime($data->ctime))'
                        ),            
                
                        array(                                 //新增可操作按鈕
                            'header'=>' ',
                            'class'=>'CButtonColumn',
                            'template'=>'{leave1}{leave2}',       //yii預設
                            'buttons'=>array(
                                'leave1'=>array(   //與'template'名稱對應
                                            'label'=>'假單',  
                                             'url'=>'Yii::app()->createUrl("tbaLog/updateLeave", array("id"=>$data->id))',               
                                            'options'=>array('class'=>'for-leave-prove-class'),
                                            'visible'=>'$data->leavecheck == "1" && $data->logtype =="1" && $data->opt2 =="0"',     //是否隱藏 1是0否
                                        ),
                                'leave2'=>array(
                                            'label'=>'假單',  
                                             'url'=>'Yii::app()->createUrl("tbaLog/updateLeave", array("id"=>$data->id))',               
                                            'options'=>array('class'=>'for-leave-prove-class','style'=>$bg1),
                                            'visible'=>'$data->leavecheck== "0" && $data->logtype =="1" && $data->opt2 =="0"', 
                                        ),                
                                ),
                        ),
                        array(
                            'header'=>' ',
                            'class'=>'CButtonColumn',
                            'template'=>'{prove1}{prove2}',
                            'buttons'=>array(
                                'prove1'=>array(
                                    'label'=>'證明',  
                                    'url'=>'Yii::app()->createUrl("tbaLog/updateProve", array("id"=>$data->id))',  
                                    'options'=>array('class'=>'for-leave-prove-class'),
                                     'visible'=>'$data->provecheck == "1" && $data->logtype =="1" && $data->opt2 =="0"', 
                                ), 
                            'prove2'=>array(
                                    'label'=>'證明',  
                                    'url'=>'Yii::app()->createUrl("tbaLog/updateProve", array("id"=>$data->id))',  
                                    'options'=>array('class'=>'for-leave-prove-class','style'=>$bg2),
                                    'visible'=>'$data->provecheck == "0" && $data->logtype =="1" && $data->opt2 =="0"', 
                                ),    
                            ),
                        ),
                        array(
                            'header'=>' ',
                            'class'=>'CButtonColumn',
                            'template'=>'{class1}{class2}',
                            'buttons'=>array(
                                'class1'=>array(
                                    'label'=>'輪值',  
                                     'url'=>'Yii::app()->createUrl("tbaLog/updateClass", array("id"=>$data->id))',   
                                     'options'=>array('class'=>'for-leave-prove-class'),
                                     'visible'=>'$data->classcheck == "1" && $data->logtype =="1" && $data->opt2 =="0"', 
                                ),
                                'class2'=>array(
                                     'label'=>'輪值',  
                                     'url'=>'Yii::app()->createUrl("tbaLog/updateClass", array("id"=>$data->id))',   
                                     'options'=>array('class'=>'for-leave-prove-class','style'=>$bg3),
                                     'visible'=>'$data->classcheck == "0" && $data->logtype =="1" && $data->opt2 =="0"', 
                                ),
                            ),
                        ),
                        array(
                                 'class'=>'CButtonColumn',
                                 'header' => '操作',  
                                 'template'=>'{update}{delete}',
                         ),
                    ),
                )
            ); 
?>