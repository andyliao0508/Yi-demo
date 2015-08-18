<?php
/* @var $this TbaHolidayController */
/* @var $dataProvider CActiveDataProvider */

$this->menu=array(
	array('label'=>'建立JIT國定假日', 'url'=>array('create')),
	array('label'=>'管理JIT國定假日', 'url'=>array('admin')),
);
?>

<h1>JIT國定假日</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
