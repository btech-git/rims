<?php
/* @var $this TransactionDeliveryOrderController */
/* @var $data TransactionDeliveryOrder */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivery_order_no')); ?>:</b>
	<?php echo CHtml::encode($data->delivery_order_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivery_date')); ?>:</b>
	<?php echo CHtml::encode($data->delivery_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('posting_date')); ?>:</b>
	<?php echo CHtml::encode($data->posting_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sender_id')); ?>:</b>
	<?php echo CHtml::encode($data->sender_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sender_branch_id')); ?>:</b>
	<?php echo CHtml::encode($data->sender_branch_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('request_type')); ?>:</b>
	<?php echo CHtml::encode($data->request_type); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('sales_order_id')); ?>:</b>
	<?php echo CHtml::encode($data->sales_order_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sent_request_id')); ?>:</b>
	<?php echo CHtml::encode($data->sent_request_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('request_date')); ?>:</b>
	<?php echo CHtml::encode($data->request_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estimate_arrival_date')); ?>:</b>
	<?php echo CHtml::encode($data->estimate_arrival_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('destination_branch')); ?>:</b>
	<?php echo CHtml::encode($data->destination_branch); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_id')); ?>:</b>
	<?php echo CHtml::encode($data->customer_id); ?>
	<br />

	*/ ?>

</div>