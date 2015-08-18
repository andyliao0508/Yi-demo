<?php
/* @var $this TbpOutputLogController */
/* @var $model TbpOutputLog */

//$this->breadcrumbs=array(
//	'Tbp Output Logs'=>array('index'),
//	'Manage',
//);

$this->menu=array(
//	array('label'=>'List TbpOutputLog', 'url'=>array('index')),
	array('label'=>'新增', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tbp-output-log-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>管理支出紀錄</h1>

<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tbp-output-log-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'pdate',
		'storecode',
		'storename',
		'itemid',
		'itemname',
		/*
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
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
