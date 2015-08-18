<?php
/* @var $this TbaLogItemController */
/* @var $model TbaLogItem */

$this->menu=array(	
	array('label'=>'建立項目', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tba-log-item-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>差勤項目管理</h1>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tba-log-item-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'logname',
//		'cname',
//		'ename',
		'logtype',
		'seqno',

		'days',
		'baseday',
		'unit',
		'sex',
		'position',
		'salaryitem',
		'basewage',
		'overtime',
		'optshow',
		'weight',
		'memo',
		'opt1',
		'opt2',
           		'opt3',
            /*
		'opt4',
		'opt5',
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
