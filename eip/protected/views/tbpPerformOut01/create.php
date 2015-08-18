<?php
/* @var $this TbpPerformOut01Controller */
/* @var $model TbpPerformOut01 */

$this->breadcrumbs=array(
	'Tbp Perform Out01s'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TbpPerformOut01', 'url'=>array('index')),
	array('label'=>'Manage TbpPerformOut01', 'url'=>array('admin')),
);
?>

<h1>Create TbpPerformOut01</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>