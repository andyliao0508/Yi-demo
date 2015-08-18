<?php
/* @var $this TbaBoardController */
/* @var $model TbaBoard */

$this->menu=array(
	array('label'=>'公告清單', 'url'=>array('index')),
	array('label'=>'建立公告', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tba-board-grid').yiiGridView('update', {
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
	'id'=>'tba-board-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		//'content',
               'imagename',
                /* 'imageurl',
                'imagetype',
		'boarddepart',
		'type',
		'priority',
		
		'depart',
		'area',
		'store',*/
		'dates',
		'datee',
		'opt1',
		'opt2',
		'opt3',
		'cemp',
		/*'ctime',
		'uemp',
		'utime',
		'ip',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
