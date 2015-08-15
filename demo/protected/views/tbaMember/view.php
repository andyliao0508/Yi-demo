<?php
/* @var $this TbaMemberController */
/* @var $model TbaMember */

$this->breadcrumbs=array(
	'Tba Members'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TbaMember', 'url'=>array('index')),
	array('label'=>'Create TbaMember', 'url'=>array('create')),
	array('label'=>'Update TbaMember', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TbaMember', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TbaMember', 'url'=>array('admin')),
);
?>

<h1>View TbaMember #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'cname',
		'ename',
		'sex',
	),
)); ?>
