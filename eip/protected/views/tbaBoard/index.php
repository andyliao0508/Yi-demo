<?php
/* @var $this TbaBoardController */
/* @var $dataProvider CActiveDataProvider */

$this->menu=array(
	array('label'=>'建立公告', 'url'=>array('create')),
	array('label'=>'管理公告', 'url'=>array('admin')),
);
?>

<h1>公告</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
