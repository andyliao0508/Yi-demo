<?php
/* @var $this TbaMemberController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tba Members',
);

$this->menu=array(
	array('label'=>'Create TbaMember', 'url'=>array('create')),
	array('label'=>'Manage TbaMember', 'url'=>array('admin')),
);
?>

<h1>Tba Members</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
