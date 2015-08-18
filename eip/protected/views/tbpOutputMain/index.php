<?php
/* @var $this TbpOutputMainController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tbp Output Mains',
);

$this->menu=array(
	array('label'=>'Create TbpOutputMain', 'url'=>array('create')),
	array('label'=>'Manage TbpOutputMain', 'url'=>array('admin')),
);
?>

<h1>Tbp Output Mains</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
