<?php
/* @var $this TbaParamCrudController */
/* @var $dataProvider CActiveDataProvider */

$this->menu=array(
	array('label'=>'建立公用變數', 'url'=>array('create')),
	array('label'=>'管理公用變數', 'url'=>array('admin')),
);
?>

<h1>差勤獎懲公用變數</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
