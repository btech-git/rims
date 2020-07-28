<?php
/* @var $this TransactionPurchaseOrderDetailController */
/* @var $data TransactionPurchaseOrderDetail */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('purchase_order_id')); ?>:</b>
	<?php echo CHtml::encode($data->purchase_order_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('request_order_id')); ?>:</b>
	<?php echo CHtml::encode($data->request_order_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('branch_addressed_to')); ?>:</b>
	<?php echo CHtml::encode($data->branch_addressed_to); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unit_id')); ?>:</b>
	<?php echo CHtml::encode($data->unit_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount_percent')); ?>:</b>
	<?php echo CHtml::encode($data->discount_percent); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('discount_nominal')); ?>:</b>
	<?php echo CHtml::encode($data->discount_nominal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subtotal')); ?>:</b>
	<?php echo CHtml::encode($data->subtotal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('request_order_quantity_rest')); ?>:</b>
	<?php echo CHtml::encode($data->request_order_quantity_rest); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('receive_order_quantity')); ?>:</b>
	<?php echo CHtml::encode($data->receive_order_quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('purchase_order_quantity_rest')); ?>:</b>
	<?php echo CHtml::encode($data->purchase_order_quantity_rest); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notes')); ?>:</b>
	<?php echo CHtml::encode($data->notes); ?>
	<br />

	*/ ?>

</div>