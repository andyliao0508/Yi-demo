<?php
/* @var $this TbaBoardController */
/* @var $model TbaBoard */

$this->menu=array(
	array('label'=>'公告清單', 'url'=>array('index')),
	array('label'=>'建立公告', 'url'=>array('create')),
	array('label'=>'更新公告', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'刪除公告', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'您確定要刪除此公告項目?')),
	array('label'=>'管理公告', 'url'=>array('admin')),
);
?>

<h1>View TbaBoard #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'content',
                'imagename',
              /*  'imageurl',
                'imagetype',
		'boarddepart',
		'type',
		'priority',
		'depart',
		'area',
		'store',
		'dates',
		'datee',
		'opt1',
		'opt2',
		'opt3',
		'cemp',
		'ctime',
		'uemp',
		'utime',
		'ip',*/
	),
)); ?>
