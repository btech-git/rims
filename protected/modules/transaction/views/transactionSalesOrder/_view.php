<?php
/* @var $this TransactionSalesOrderController */
/* @var $data TransactionSalesOrder */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sale_order_no')); ?>:</b>
	<?php echo CHtml::encode($data->sale_order_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sale_order_date')); ?>:</b>
	<?php echo CHtml::encode($data->sale_order_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_document')); ?>:</b>
	<?php echo CHtml::encode($data->status_document); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_type')); ?>:</b>
	<?php echo CHtml::encode($data->payment_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estimate_arrival_date')); ?>:</b>
	<?php echo CHtml::encode($data->estimate_arrival_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('requester_id')); ?>:</b>
	<?php echo CHtml::encode($data->requester_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('requester_branch_id')); ?>:</b>
	<?php echo CHtml::encode($data->requester_branch_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approved_id')); ?>:</b>
	<?php echo CHtml::encode($data->approved_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approved_branch_id')); ?>:</b>
	<?php echo CHtml::encode($data->approved_branch_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_id')); ?>:</b>
	<?php echo CHtml::encode($data->customer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_quantity')); ?>:</b>
	<?php echo CHtml::encode($data->total_quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_price')); ?>:</b>
	<?php echo CHtml::encode($data->total_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estimate_payment_date')); ?>:</b>
	<?php echo CHtml::encode($data->estimate_payment_date); ?>
	<br />

	*/ ?>

</div>