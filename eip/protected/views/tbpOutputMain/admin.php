<?php
/* @var $this TbpOutputMainController */
/* @var $model TbpOutputMain */

//$this->breadcrumbs=array(
//	'Tbp Output Mains'=>array('index'),
//	'Manage',
//);

$this->menu=array(
//	array('label'=>'List TbpOutputMain', 'url'=>array('index')),
	array('label'=>'新增', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tbp-output-main-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>管理支出主項</h1>


<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tbp-output-main-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'cname',
		'ename',
		'feeno',
		'account',
		'memo',
		/*
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
