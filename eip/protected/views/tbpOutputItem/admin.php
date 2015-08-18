<?php
/* @var $this TbpOutputItemController */
/* @var $model TbpOutputItem */

//$this->breadcrumbs=array(
//	'Tbp Output Items'=>array('index'),
//	'Manage',
//);

$this->menu=array(
//	array('label'=>'List TbpOutputItem', 'url'=>array('index')),
	array('label'=>'新增支出細項', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tbp-output-item-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>管理支出細項</h1>


<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tbp-output-item-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'cname',
		'ename',
		'mainid',
		'subid',
		'type',
                                      'summary',
                                      'memo',
		/*
		'feeno',
		'account',
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
