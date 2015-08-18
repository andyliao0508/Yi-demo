<?php
/* @var $this TbpParamController */
/* @var $model TbpParam */

$this->breadcrumbs=array(
	'Tbp Params'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TbpParam', 'url'=>array('index')),
	array('label'=>'Create TbpParam', 'url'=>array('create')),
	array('label'=>'View TbpParam', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TbpParam', 'url'=>array('admin')),
);
?>

<h1>Update TbpParam <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>