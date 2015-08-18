<?php
/* @var $this TbaLogController */
/* @var $data TbaLog */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('logday')); ?>:</b>
	<?php echo CHtml::encode($data->logday); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('empno')); ?>:</b>
	<?php echo CHtml::encode($data->empno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('empname')); ?>:</b>
	<?php echo CHtml::encode($data->empname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('logtype')); ?>:</b>
	<?php echo CHtml::encode($data->logtype); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('logitem')); ?>:</b>
	<?php echo CHtml::encode($data->logitem); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('logname')); ?>:</b>
	<?php echo CHtml::encode($data->logname); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('num')); ?>:</b>
	<?php echo CHtml::encode($data->num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leavecheck')); ?>:</b>
	<?php echo CHtml::encode($data->leave); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('leavefile')); ?>:</b>
	<?php echo CHtml::encode($data->leavefile); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('provecheck')); ?>:</b>
	<?php echo CHtml::encode($data->prove); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('provefile')); ?>:</b>
	<?php echo CHtml::encode($data->provefile); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('classcheck')); ?>:</b>
	<?php echo CHtml::encode($data->class); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('classfile')); ?>:</b>
	<?php echo CHtml::encode($data->classfile); ?>
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