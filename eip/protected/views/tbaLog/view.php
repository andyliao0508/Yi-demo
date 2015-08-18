<?php
/* @var $this TbaLogController */
/* @var $model TbaLog */

$this->menu=array(	
	array('label'=>'建立差勤獎懲紀錄查詢', 'url'=>array('create')),
	array('label'=>'更新差勤獎懲紀錄查詢', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'刪除差勤獎懲紀錄查詢', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'您確定要刪除此公用變數項目?')), 
	array('label'=>'管理差勤獎懲紀錄查詢', 'url'=>array('admin')),
);
?>

<h1>View TbaLog #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'logday',
		'empno',
		'empname',
		'logtype',
		'logitem',
		'logname',
		'num',
		'leavecheck',
		'leavefile',
		'provecheck',
		'provefile',
		'classcheck',
		'classfile',
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
