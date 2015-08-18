<?php
/* @var $this TbaBoardEmpLogController */
/* @var $data TbaBoardEmpLog */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('board_id')); ?>:</b>
	<?php echo CHtml::encode($data->board_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('board_title')); ?>:</b>
	<?php echo CHtml::encode($data->board_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('empno')); ?>:</b>
	<?php echo CHtml::encode($data->empno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('empname')); ?>:</b>
	<?php echo CHtml::encode($data->empname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('read')); ?>:</b>
	<?php echo CHtml::encode($data->read); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('opt1')); ?>:</b>
	<?php echo CHtml::encode($data->opt1); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('opt2')); ?>:</b>
	<?php echo CHtml::encode($data->opt2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('opt3')); ?>:</b>
	<?php echo CHtml::encode($data->opt3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cemp')); ?>:</b>
	<?php echo CHtml::encode($data->cemp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ctime')); ?>:</b>
	<?php echo CHtml::encode($data->ctime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('uemp')); ?>:</b>
	<?php echo CHtml::encode($data->uemp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('utime')); ?>:</b>
	<?php echo CHtml::encode($data->utime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ip')); ?>:</b>
	<?php echo CHtml::encode($data->ip); ?>
	<br />

	*/ ?>

</div>