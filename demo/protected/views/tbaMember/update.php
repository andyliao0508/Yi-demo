<?php
/* @var $this TbaMemberController */
/* @var $model TbaMember */

$this->breadcrumbs=array(
	'Tba Members'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TbaMember', 'url'=>array('index')),
	array('label'=>'Create TbaMember', 'url'=>array('create')),
	array('label'=>'View TbaMember', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TbaMember', 'url'=>array('admin')),
);
?>

<h1>Update TbaMember <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>