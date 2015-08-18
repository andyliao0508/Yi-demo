<?php
/* @var $this TbaWeightController */
/* @var $model TbaWeight */

$this->menu=array(
	array('label'=>'管理差勤獎懲權重', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>