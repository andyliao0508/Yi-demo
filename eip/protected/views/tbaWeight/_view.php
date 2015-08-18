<?php
/* @var $this TbaWeightController */
/* @var $data TbaWeight */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('logitem')); ?>:</b>
	<?php echo CHtml::encode($data->logitem); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nweight')); ?>:</b>
	<?php echo CHtml::encode($data->nweight); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hweight')); ?>:</b>
	<?php echo CHtml::encode($data->hweight); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('memo')); ?>:</b>
	<?php echo CHtml::encode($data->memo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('opt1')); ?>:</b>
	<?php echo CHtml::encode($data->opt1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('opt2')); ?>:</b>
	<?php echo CHtml::encode($data->opt2); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('opt3')); ?>:</b>
	<?php echo CHtml::encode($data->opt3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cemp')); ?>:</b>
	<?php echo CHtml::encode($data->cemp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('uemp')); ?>:</b>
	<?php echo CHtml::encode($data->uemp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ctime')); ?>:</b>
	<?php echo CHtml::encode($data->ctime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('utime')); ?>:</b>
	<?php echo CHtml::encode($data->utime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ip')); ?>:</b>
	<?php echo CHtml::encode($data->ip); ?>
	<br />

	*/ ?>

</div>