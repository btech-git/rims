<?php
/* @var $this TransactionTransferRequestController */
/* @var $data TransactionTransferRequest */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transfer_request_no')); ?>:</b>
	<?php echo CHtml::encode($data->transfer_request_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transfer_request_date')); ?>:</b>
	<?php echo CHtml::encode($data->transfer_request_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_document')); ?>:</b>
	<?php echo CHtml::encode($data->status_document); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estimate_arrival_date')); ?>:</b>
	<?php echo CHtml::encode($data->estimate_arrival_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requester_id')); ?>:</b>
	<?php echo CHtml::encode($data->requester_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requester_branch_id')); ?>:</b>
	<?php echo CHtml::encode($data->requester_branch_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('approved_by')); ?>:</b>
	<?php echo CHtml::encode($data->approved_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('destination_id')); ?>:</b>
	<?php echo CHtml::encode($data->destination_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('destination_branch_id')); ?>:</b>
	<?php echo CHtml::encode($data->destination_branch_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_quantity')); ?>:</b>
	<?php echo CHtml::encode($data->total_quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_price')); ?>:</b>
	<?php echo CHtml::encode($data->total_price); ?>
	<br />

	*/ ?>

</div>