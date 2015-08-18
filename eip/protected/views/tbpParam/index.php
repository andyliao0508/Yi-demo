<?php
/* @var $this TbpParamController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tbp Params',
);

$this->menu=array(
	array('label'=>'Create TbpParam', 'url'=>array('create')),
	array('label'=>'Manage TbpParam', 'url'=>array('admin')),
);
?>

<h1>Tbp Params</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
