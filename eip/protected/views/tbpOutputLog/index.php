<?php
/* @var $this TbpOutputLogController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tbp Output Logs',
);

$this->menu=array(
	array('label'=>'Create TbpOutputLog', 'url'=>array('create')),
	array('label'=>'Manage TbpOutputLog', 'url'=>array('admin')),
);
?>

<h1>Tbp Output Logs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
