<?php
/* @var $this TbpPerformOut01Controller */
/* @var $model TbpPerformOut01 */

$this->breadcrumbs=array(
	'Tbp Perform Out01s'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TbpPerformOut01', 'url'=>array('index')),
	array('label'=>'Create TbpPerformOut01', 'url'=>array('create')),
	array('label'=>'View TbpPerformOut01', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TbpPerformOut01', 'url'=>array('admin')),
);
?>

<h1>Update TbpPerformOut01 <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>