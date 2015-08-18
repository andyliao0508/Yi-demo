<?php
/* @var $this TbaBoardController */
/* @var $model TbaBoard */

$this->menu=array(
	array('label'=>'公告清單', 'url'=>array('index')),
	array('label'=>'建立公告', 'url'=>array('create')),
	array('label'=>'公告內容', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'管理公告', 'url'=>array('admin')),
);
?>

<h1>更新公告: <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>