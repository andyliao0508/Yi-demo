<?php
/* @var $this TbaBoardEmpLogController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tba Board Emp Logs',
);

$this->menu=array(
	array('label'=>'Create TbaBoardEmpLog', 'url'=>array('create')),
	array('label'=>'Manage TbaBoardEmpLog', 'url'=>array('admin')),
);
?>

<h1>Tba Board Emp Logs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
