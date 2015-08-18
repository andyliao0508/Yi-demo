<?php
/* @var $this TbaHolidayController */
/* @var $model TbaHoliday */


$this->menu=array(
	array('label'=>'管理JIT國定假日', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>