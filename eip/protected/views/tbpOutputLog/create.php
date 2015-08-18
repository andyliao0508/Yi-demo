<?php
/* @var $this TbpOutputLogController */
/* @var $model TbpOutputLog */

//$this->breadcrumbs=array(
//	'Tbp Output Logs'=>array('index'),
//	'Create',
//);

$this->menu=array(
//	array('label'=>'List TbpOutputLog', 'url'=>array('index')),
	array('label'=>'管理支出紀錄', 'url'=>array('admin')),
);
?>

<h1>新增支出紀錄</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>