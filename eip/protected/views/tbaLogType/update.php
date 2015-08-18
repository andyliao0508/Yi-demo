<?php
/* @var $this TbaLogTypeController */
/* @var $model TbaLogType */

$this->menu=array(	
	array('label'=>'建立差勤獎懲類別', 'url'=>array('create')),
	array('label'=>'差勤獎懲類別內容', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'管理差勤獎懲類別', 'url'=>array('admin')),
);
?>

<h1>更新類別: <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>