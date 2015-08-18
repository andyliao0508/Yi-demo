<?php
/* @var $this TbaParamCrudController */
/* @var $model TbaParamCrud */

$this->menu=array(	
	array('label'=>'建立公用變數', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tba-param-crud-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tba-param-crud-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'param',
		'cname',
		'pvalue',
		'memo',
		'opt1',
		/*
		'opt2',
		'opt3',
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
