<?php
/* @var $this TbaBoardEmpLogController */
/* @var $model TbaBoardEmpLog */

$this->breadcrumbs=array(
	'Tba Board Emp Logs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TbaBoardEmpLog', 'url'=>array('index')),
	array('label'=>'Create TbaBoardEmpLog', 'url'=>array('create')),
	array('label'=>'View TbaBoardEmpLog', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TbaBoardEmpLog', 'url'=>array('admin')),
);
?>

<h1>Update TbaBoardEmpLog <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>