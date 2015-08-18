<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - 發生錯誤';
//$this->breadcrumbs=array(
//	'Error',
//);
?>

<h2>發生錯誤： <?php echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>