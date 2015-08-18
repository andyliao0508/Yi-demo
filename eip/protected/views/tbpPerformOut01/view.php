<?php
/* @var $this TbpPerformOut01Controller */
/* @var $model TbpPerformOut01 */

$this->breadcrumbs=array(
	'Tbp Perform Out01s'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List TbpPerformOut01', 'url'=>array('index')),
	array('label'=>'Create TbpPerformOut01', 'url'=>array('create')),
	array('label'=>'Update TbpPerformOut01', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TbpPerformOut01', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TbpPerformOut01', 'url'=>array('admin')),
);
?>

<h1>View TbpPerformOut01 #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'item',
		'sequence',
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
