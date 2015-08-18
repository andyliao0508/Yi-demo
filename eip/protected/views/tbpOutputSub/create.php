<?php
/* @var $this TbpOutputSubController */
/* @var $model TbpOutputSub */

//$this->breadcrumbs=array(
//	'Tbp Output Subs'=>array('index'),
//	'Create',
//);

$this->menu=array(
//	array('label'=>'List TbpOutputSub', 'url'=>array('index')),
	array('label'=>'管理支出次項', 'url'=>array('admin')),
);
?>

<h1>新增支出次項</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>