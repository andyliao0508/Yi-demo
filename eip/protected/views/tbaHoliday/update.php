<?php
/* @var $this TbaHolidayController */
/* @var $model TbaHoliday */

$this->menu=array(	
	array('label'=>'建立JIT國定假日', 'url'=>array('create')),
	array('label'=>'JIT假日內容', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'管理JIT國定假日', 'url'=>array('admin')),
);
?>

<h1>更新假日: <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>