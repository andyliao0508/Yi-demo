<?php
/* @var $this TbaParamController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tba Params',
);

$this->menu=array(
	array('label'=>'Create TbaParam', 'url'=>array('create')),
	array('label'=>'Manage TbaParam', 'url'=>array('admin')),
);
?>

<h1>Tba Params</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
