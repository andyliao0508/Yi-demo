<?php
/* @var $this TbpParamController */
/* @var $model TbpParam */

$this->breadcrumbs=array(
	'Tbp Params'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TbpParam', 'url'=>array('index')),
	array('label'=>'Manage TbpParam', 'url'=>array('admin')),
);
?>

<h1>Create TbpParam</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>