<?php
/* @var $this TbaLogItemController */
/* @var $model TbaLogItem */

$this->menu=array(	
	array('label'=>'建立差勤獎懲項目', 'url'=>array('create')),
	array('label'=>'差勤獎懲項目內容', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'管理差勤獎懲項目', 'url'=>array('admin')),
);
?>

<h1>更新項目: <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>