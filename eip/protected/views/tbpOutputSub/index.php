<?php
/* @var $this TbpOutputSubController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tbp Output Subs',
);

$this->menu=array(
	array('label'=>'Create TbpOutputSub', 'url'=>array('create')),
	array('label'=>'Manage TbpOutputSub', 'url'=>array('admin')),
);
?>

<h1>Tbp Output Subs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
