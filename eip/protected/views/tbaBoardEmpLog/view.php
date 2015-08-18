<?php
/* @var $this TbaBoardEmpLogController */
/* @var $model TbaBoardEmpLog */

$this->breadcrumbs=array(
	'Tba Board Emp Logs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TbaBoardEmpLog', 'url'=>array('index')),
	array('label'=>'Create TbaBoardEmpLog', 'url'=>array('create')),
	array('label'=>'Update TbaBoardEmpLog', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TbaBoardEmpLog', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TbaBoardEmpLog', 'url'=>array('admin')),
);
?>

<h1>View TbaBoardEmpLog #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'board_id',
		'board_title',
		'empno',
		'empname',
		'read',
		'opt1',
		'opt2',
		'opt3',
		'cemp',
		'ctime',
		'uemp',
		'utime',
		'ip',
	),
)); ?>
