<?php
/* @var $this TbaBoardController */
/* @var $model TbaBoard */

$this->menu=array(
	array('label'=>'公告清單', 'url'=>array('index')),
	array('label'=>'管理公告', 'url'=>array('admin')),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>