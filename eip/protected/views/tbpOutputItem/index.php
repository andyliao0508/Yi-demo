<?php
/* @var $this TbpOutputItemController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tbp Output Items',
);

$this->menu=array(
	array('label'=>'Create TbpOutputItem', 'url'=>array('create')),
	array('label'=>'Manage TbpOutputItem', 'url'=>array('admin')),
);
?>

<h1>Tbp Output Items</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
