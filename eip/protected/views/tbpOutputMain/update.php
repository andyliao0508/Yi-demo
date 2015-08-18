<?php
/* @var $this TbpOutputMainController */
/* @var $model TbpOutputMain */

//$this->breadcrumbs=array(
//	'Tbp Output Mains'=>array('index'),
//	$model->id=>array('view','id'=>$model->id),
//	'Update',
//);

$this->menu=array(
//	array('label'=>'List TbpOutputMain', 'url'=>array('index')),
	array('label'=>'新增', 'url'=>array('create')),
//	array('label'=>'View TbpOutputMain', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'管理支出主項', 'url'=>array('admin')),
);
?>

<h1>修改支出主項 <?php echo $model->cname; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>