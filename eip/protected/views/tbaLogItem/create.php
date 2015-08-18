<?php
/* @var $this TbaLogItemController */
/* @var $model TbaLogItem */

$this->menu=array(
	array('label'=>'管理差勤獎懲項目', 'url'=>array('admin')),
);
?>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>