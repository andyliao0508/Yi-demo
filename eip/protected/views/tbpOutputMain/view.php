<?php
/* @var $this TbpOutputMainController */
/* @var $model TbpOutputMain */

//$this->breadcrumbs=array(
//	'Tbp Output Mains'=>array('index'),
//	$model->id,
//);

$this->menu=array(
//	array('label'=>'List TbpOutputMain', 'url'=>array('index')),
	array('label'=>'新增', 'url'=>array('create')),
	array('label'=>'修改', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'刪除', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'管理支出主項', 'url'=>array('admin')),
);
?>

<h1>支出主項 #<?php echo $model->cname; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'cname',
		'ename',
		'feeno',
		'account',
		'memo',
		'opt1',
		'cemp',
		'uemp',
		'ctime',
		'utime',
		'ip',
	),
)); ?>
