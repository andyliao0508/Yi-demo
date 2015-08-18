<?php
/* @var $this TbpOutputLogController */
/* @var $data TbpOutputLog */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pdate')); ?>:</b>
	<?php echo CHtml::encode($data->pdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('storecode')); ?>:</b>
	<?php echo CHtml::encode($data->storecode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('storename')); ?>:</b>
	<?php echo CHtml::encode($data->storename); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('itemid')); ?>:</b>
	<?php echo CHtml::encode($data->itemid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('itemname')); ?>:</b>
	<?php echo CHtml::encode($data->itemname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mainid')); ?>:</b>
	<?php echo CHtml::encode($data->mainbid); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('subid')); ?>:</b>
	<?php echo CHtml::encode($data->subid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('feeno')); ?>:</b>
	<?php echo CHtml::encode($data->feeno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account')); ?>:</b>
	<?php echo CHtml::encode($data->account); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('num')); ?>:</b>
	<?php echo CHtml::encode($data->num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dates')); ?>:</b>
	<?php echo CHtml::encode($data->dates); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('datee')); ?>:</b>
	<?php echo CHtml::encode($data->datee); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('temp1')); ?>:</b>
	<?php echo CHtml::encode($data->temp1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('temp2')); ?>:</b>
	<?php echo CHtml::encode($data->temp2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('temp3')); ?>:</b>
	<?php echo CHtml::encode($data->temp3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('memo')); ?>:</b>
	<?php echo CHtml::encode($data->memo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('opt1')); ?>:</b>
	<?php echo CHtml::encode($data->opt1); ?>
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