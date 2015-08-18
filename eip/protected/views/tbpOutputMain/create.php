<?php
/* @var $this TbpOutputMainController */
/* @var $model TbpOutputMain */

//$this->breadcrumbs=array(
//	'Tbp Output Mains'=>array('index'),
//	'Create',
//);

$this->menu=array(
//	array('label'=>'List TbpOutputMain', 'url'=>array('index')),
	array('label'=>'管理支出主項', 'url'=>array('admin')),
);
?>

<h1>新增支出主項</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>