<?php
/* @var $this TbaParamController */
/* @var $model TbaParam */

$this->breadcrumbs=array(
	'Tba Params'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TbaParam', 'url'=>array('index')),
	array('label'=>'Create TbaParam', 'url'=>array('create')),
	array('label'=>'Update TbaParam', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TbaParam', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TbaParam', 'url'=>array('admin')),
);
?>

<h1>View TbaParam #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'param',
		'cname',
		'pvalue',
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
