<?php
/* @var $this TransactionDeliveryOrderDetailController */
/* @var $data TransactionDeliveryOrderDetail */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivery_order_id')); ?>:</b>
	<?php echo CHtml::encode($data->delivery_order_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity_request')); ?>:</b>
	<?php echo CHtml::encode($data->quantity_request); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity_delivery')); ?>:</b>
	<?php echo CHtml::encode($data->quantity_delivery); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity_request_left')); ?>:</b>
	<?php echo CHtml::encode($data->quantity_request_left); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('barcode_product')); ?>:</b>
	<?php echo CHtml::encode($data->barcode_product); ?>
	<br />

	*/ ?>

</div>