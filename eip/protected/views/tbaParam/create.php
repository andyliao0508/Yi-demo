<?php
/* @var $this TbaParamController */
/* @var $model TbaParam */

$this->breadcrumbs=array(
	'Tba Params'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TbaParam', 'url'=>array('index')),
	array('label'=>'Manage TbaParam', 'url'=>array('admin')),
);
?>

<h1>Create TbaParam</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>