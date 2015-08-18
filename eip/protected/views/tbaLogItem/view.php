<?php
/* @var $this TbaLogItemController */
/* @var $model TbaLogItem */

$this->menu=array(	
	array('label'=>'建立差勤獎懲項目', 'url'=>array('create')),
	array('label'=>'更新項目', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'刪除差勤獎懲項目', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'您確定要刪除此公告項目?')),
	array('label'=>'管理差勤獎懲項目', 'url'=>array('admin')),
);
?>

<h1>View TbaLogItem #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'logname',
		'cname',
		'ename',
		'logtype',
		'seqno',
		'days',
		'baseday',
		'unit',
		'sex',
		'position',
		'salaryitem',
		'basewage',
		'overtime',
		'optshow',
		'weight',
		'memo',
		'opt1',
		'opt2',
		'opt3',
		'opt4',
		'opt5',
		'cemp',
		'uemp',
		'ctime',
		'utime',
		'ip',
	),
)); ?>
