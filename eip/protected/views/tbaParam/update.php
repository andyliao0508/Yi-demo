<?php
/* @var $this TbaParamController */
/* @var $model TbaParam */

$this->breadcrumbs=array(
	'Tba Params'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TbaParam', 'url'=>array('index')),
	array('label'=>'Create TbaParam', 'url'=>array('create')),
	array('label'=>'View TbaParam', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TbaParam', 'url'=>array('admin')),
);
?>

<h1>Update TbaParam <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>