<?php
/* @var $this MovementInHeaderController */
/* @var $data MovementInHeader */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('movement_in_number')); ?>:</b>
	<?php echo CHtml::encode($data->movement_in_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_posting')); ?>:</b>
	<?php echo CHtml::encode($data->date_posting); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('branch_id')); ?>:</b>
	<?php echo CHtml::encode($data->branch_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('receive_item_id')); ?>:</b>
	<?php echo CHtml::encode($data->receive_item_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supervisor_id')); ?>:</b>
	<?php echo CHtml::encode($data->supervisor_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>