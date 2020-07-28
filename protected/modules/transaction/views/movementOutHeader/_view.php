<?php
/* @var $this MovementOutHeaderController */
/* @var $data MovementOutHeader */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('movement_out_no')); ?>:</b>
	<?php echo CHtml::encode($data->movement_out_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_posting')); ?>:</b>
	<?php echo CHtml::encode($data->date_posting); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivery_order_id')); ?>:</b>
	<?php echo CHtml::encode($data->delivery_order_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('branch_id')); ?>:</b>
	<?php echo CHtml::encode($data->branch_id); ?>
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