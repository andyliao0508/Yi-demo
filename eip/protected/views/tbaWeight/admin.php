<?php
/* @var $this TbaWeightController */
/* @var $model TbaWeight */

$this->menu=array(	
	array('label'=>'建立差勤獎懲權重', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tba-weight-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>管理差勤獎懲權重</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tba-weight-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'logitem',
                                        array(
                                            'name' => 'logname',
                                            'value' => 'isset($data->log)?$data->log->logname:""',
                                        ),            
		'nweight',
		'hweight',
		'memo',
		'opt1',		
		'opt2',
            /*
		'opt3',
		'cemp',
		'uemp',
		'ctime',
		'utime',
		'ip',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
