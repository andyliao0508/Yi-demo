<?php
/* @var $this TbaParamCrudController */
/* @var $model TbaParamCrud */

$this->menu=array(
	array('label'=>'管理公用變數', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>