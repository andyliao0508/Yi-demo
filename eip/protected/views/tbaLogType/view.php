<?php
/* @var $this TbaLogTypeController */
/* @var $model TbaLogType */

$this->menu=array(	
	array('label'=>'建立類別', 'url'=>array('create')),
	array('label'=>'更新類別', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'刪除類別', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'您確定要刪除此公告項目?')),
	array('label'=>'管理類別', 'url'=>array('admin')),
);
?>

<h1>View TbaLogType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'cname',
		'ename',
		'memo',
		'opt1',
		'cemp',
		'uemp',
		'ctime',
		'utime',
		'ip',
	),
)); ?>
