<?php
/* @var $this TbaParamCrudController */
/* @var $model TbaParamCrud */


$this->menu=array(
	array('label'=>'建立公用變數', 'url'=>array('create')),
	array('label'=>'公用變數內容', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'管理公用變數', 'url'=>array('admin')),
);
?>

<h1>更新變數: <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>