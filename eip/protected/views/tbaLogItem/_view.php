<?php
/* @var $this TbaLogItemController */
/* @var $data TbaLogItem */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('logname')); ?>:</b>
	<?php echo CHtml::encode($data->holiday); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cname')); ?>:</b>
	<?php echo CHtml::encode($data->cname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ename')); ?>:</b>
	<?php echo CHtml::encode($data->ename); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('logtype')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('seqno')); ?>:</b>
	<?php echo CHtml::encode($data->seqno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('days')); ?>:</b>
	<?php echo CHtml::encode($data->days); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('baseday')); ?>:</b>
	<?php echo CHtml::encode($data->baseday); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unit')); ?>:</b>
	<?php echo CHtml::encode($data->unit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sex')); ?>:</b>
	<?php echo CHtml::encode($data->sex); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('position')); ?>:</b>
	<?php echo CHtml::encode($data->position); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('salaryitem')); ?>:</b>
	<?php echo CHtml::encode($data->salaryitem); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('basewage')); ?>:</b>
	<?php echo CHtml::encode($data->basewage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('overtime')); ?>:</b>
	<?php echo CHtml::encode($data->overtime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('optshow')); ?>:</b>
	<?php echo CHtml::encode($data->optshow); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('weight')); ?>:</b>
	<?php echo CHtml::encode($data->weight); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('opt4')); ?>:</b>
	<?php echo CHtml::encode($data->opt4); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('opt5')); ?>:</b>
	<?php echo CHtml::encode($data->opt5); ?>
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


</div>