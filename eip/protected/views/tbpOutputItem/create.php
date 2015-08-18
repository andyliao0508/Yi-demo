<?php
/* @var $this TbpOutputItemController */
/* @var $model TbpOutputItem */

//$this->breadcrumbs=array(
//	'Tbp Output Items'=>array('index'),
//	'Create',
//);

$this->menu=array(
//	array('label'=>'List TbpOutputItem', 'url'=>array('index')),
	array('label'=>'管理支出細項', 'url'=>array('admin')),
);
?>

<h1>新增支出細項</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>