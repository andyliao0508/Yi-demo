<?php
/* @var $this TbpOutputItemController */
/* @var $model TbpOutputItem */

//$this->breadcrumbs=array(
//	'Tbp Output Items'=>array('index'),
//	$model->id=>array('view','id'=>$model->id),
//	'Update',
//);

$this->menu=array(
//	array('label'=>'List TbpOutputItem', 'url'=>array('index')),
	array('label'=>'新增', 'url'=>array('create')),
//	array('label'=>'View TbpOutputItem', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'管理支出細項', 'url'=>array('admin')),
);
?>

<h1>修改支出細項 <?php echo $model->cname; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>