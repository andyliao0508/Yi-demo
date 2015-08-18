<?php
/* @var $this TbaLogTypeController */
/* @var $model TbaLogType */

$this->menu=array(
	array('label'=>'管理差勤獎懲類別', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>