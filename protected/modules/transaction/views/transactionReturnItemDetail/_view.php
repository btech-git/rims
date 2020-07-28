<?php
/* @var $this TransactionReturnItemDetailController */
/* @var $data TransactionReturnItemDetail */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('return_item_id')); ?>:</b>
	<?php echo CHtml::encode($data->return_item_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('return_type')); ?>:</b>
	<?php echo CHtml::encode($data->return_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity_delivery')); ?>:</b>
	<?php echo CHtml::encode($data->quantity_delivery); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity_left')); ?>:</b>
	<?php echo CHtml::encode($data->quantity_left); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('barcode_product')); ?>:</b>
	<?php echo CHtml::encode($data->barcode_product); ?>
	<br />

	*/ ?>

</div>