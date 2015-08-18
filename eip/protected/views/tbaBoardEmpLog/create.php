<?php
/* @var $this TbaBoardEmpLogController */
/* @var $model TbaBoardEmpLog */

$this->breadcrumbs=array(
	'Tba Board Emp Logs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TbaBoardEmpLog', 'url'=>array('index')),
	array('label'=>'Manage TbaBoardEmpLog', 'url'=>array('admin')),
);
?>

<h1>Create TbaBoardEmpLog</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>