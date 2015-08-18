<?php
/* @var $this TbpPerformOut01Controller */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tbp Perform Out01s',
);

$this->menu=array(
	array('label'=>'Create TbpPerformOut01', 'url'=>array('create')),
	array('label'=>'Manage TbpPerformOut01', 'url'=>array('admin')),
);
?>

<h1>Tbp Perform Out01s</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
