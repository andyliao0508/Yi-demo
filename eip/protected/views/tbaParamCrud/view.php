<?php
/* @var $this TbaParamCrudController */
/* @var $model TbaParamCrud */

$this->menu=array(	
	array('label'=>'建立公用變數', 'url'=>array('create')),
	array('label'=>'更新公用變數', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'刪除公用變數', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'您確定要刪除此公用變數項目?')),
	array('label'=>'管理公用變數', 'url'=>array('admin')),
);
?>

<h1>View TbaParamCrud #<?php echo $model->id; ?></h1>

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
