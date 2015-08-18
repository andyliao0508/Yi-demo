<?php
/* @var $this TbaLogController */
/* @var $model TbaLog */

$this->menu=array(
//	array('label'=>'建立差勤獎懲紀錄查詢', 'url'=>array('create')),
//	array('label'=>'差勤獎懲紀錄查詢內容', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'回管理介面', 'url'=>array('querylog')),
);
?>

<h1>更新差勤獎懲紀錄: <?php echo $model->id; ?></h1>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>	
<?php $this->renderPartial('_form', array('model'=>$model)); ?>

