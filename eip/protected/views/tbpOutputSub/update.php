<?php
/* @var $this TbpOutputSubController */
/* @var $model TbpOutputSub */

//$this->breadcrumbs=array(
//	'Tbp Output Subs'=>array('index'),
//	$model->id=>array('view','id'=>$model->id),
//	'Update',
//);

$this->menu=array(
//	array('label'=>'List TbpOutputSub', 'url'=>array('index')),
	array('label'=>'新增', 'url'=>array('create')),
//	array('label'=>'View TbpOutputSub', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'管理支出次項', 'url'=>array('admin')),
);
?>

<h1>修改支出次項 <?php echo $model->cname; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>