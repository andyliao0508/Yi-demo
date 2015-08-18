<?php
/* @var $this TbaLogItemController */
/* @var $dataProvider CActiveDataProvider */

$this->menu=array(
	array('label'=>'建立差勤獎懲項目', 'url'=>array('create')),
	array('label'=>'管理差勤獎懲項目', 'url'=>array('admin')),
);
?>

<h1>差勤獎懲項目</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
