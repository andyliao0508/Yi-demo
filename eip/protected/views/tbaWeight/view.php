<?php
/* @var $this TbaWeightController */
/* @var $model TbaWeight */

$this->menu=array(	
	array('label'=>'建立差勤獎懲權重', 'url'=>array('create')),
	array('label'=>'更新權重', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'刪除差勤獎懲權重', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'您確定要刪除此公告項目?')),
	array('label'=>'管理差勤獎懲權重', 'url'=>array('admin')),
);
?>

<h1>View TbaWeight #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'logitem',
		'nweight',
		'hweight',
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
