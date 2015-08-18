<?php
/* @var $this TbaHolidayController */
/* @var $model TbaHoliday */

$this->menu=array(	
	array('label'=>'建立JIT國定假日', 'url'=>array('create')),
	array('label'=>'更新假日', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'刪除JIT國定假日', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'您確定要刪除此公告項目?')),
	array('label'=>'管理JIT國定假日', 'url'=>array('admin')),
);
?>

<h1>View TbaHoliday #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'holiday',
		'dayname',
		'memo',
		'opt1',
		'opt2',
		'opt3',
		'cemp',
		'uemp',
		'ctime',
		'utime',
		'ip',
	),
)); ?>
