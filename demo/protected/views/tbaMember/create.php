<?php
/* @var $this TbaMemberController */
/* @var $model TbaMember */

$this->breadcrumbs=array(
	'Tba Members'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TbaMember', 'url'=>array('index')),
	array('label'=>'Manage TbaMember', 'url'=>array('admin')),
);
?>

<h1>Create TbaMember</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>