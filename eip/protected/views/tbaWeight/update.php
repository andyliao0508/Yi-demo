<?php
/* @var $this TbaWeightController */
/* @var $model TbaWeight */

$this->menu=array(	
	array('label'=>'建立差勤獎懲權重', 'url'=>array('create')),
	array('label'=>'差勤獎懲權重內容', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'管理差勤獎懲權重', 'url'=>array('admin')),
);
?>

<h1>更新權重: <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>