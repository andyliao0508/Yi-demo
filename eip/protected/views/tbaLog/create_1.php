<?php
/* @var $this TbaLogController */
/* @var $model TbaLog */

$this->menu=array(
	array('label'=>'管理差勤獎懲紀錄查詢', 'url'=>array('admin')),
);
?>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>