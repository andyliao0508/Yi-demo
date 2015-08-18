<?php
/* @var $this TbpOutputLogController */
/* @var $model TbpOutputLog */

$this->breadcrumbs=array(
	'Tbp Output Logs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TbpOutputLog', 'url'=>array('index')),
	array('label'=>'Create TbpOutputLog', 'url'=>array('create')),
	array('label'=>'Update TbpOutputLog', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TbpOutputLog', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TbpOutputLog', 'url'=>array('admin')),
);
?>

<h1>View TbpOutputLog #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'pdate',
		'storecode',
		'storename',
		'itemid',
		'itemname',
		'mainid',
		'subid',
		'type',
		'feeno',
		'account',
		'num',
		'price',
		'dates',
		'datee',
		'temp1',
		'temp2',
		'temp3',
		'memo',
		'opt1',
		'cemp',
		'uemp',
		'ctime',
		'utime',
		'ip',
	),
)); ?>
