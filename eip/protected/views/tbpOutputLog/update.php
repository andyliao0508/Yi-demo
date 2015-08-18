<?php
/* @var $this TbpOutputLogController */
/* @var $model TbpOutputLog */

$this->breadcrumbs=array(
	'Tbp Output Logs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TbpOutputLog', 'url'=>array('index')),
	array('label'=>'Create TbpOutputLog', 'url'=>array('create')),
	array('label'=>'View TbpOutputLog', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TbpOutputLog', 'url'=>array('admin')),
);
?>

<h1>Update TbpOutputLog <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>