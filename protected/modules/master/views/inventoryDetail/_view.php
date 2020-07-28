<?php
/* @var $this InventoryDetailController */
/* @var $data InventoryDetail */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inventory_id')); ?>:</b>
	<?php echo CHtml::encode($data->inventory_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('warehouse_id')); ?>:</b>
	<?php echo CHtml::encode($data->warehouse_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transaction_type')); ?>:</b>
	<?php echo CHtml::encode($data->transaction_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transaction_number')); ?>:</b>
	<?php echo CHtml::encode($data->transaction_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transaction_date')); ?>:</b>
	<?php echo CHtml::encode($data->transaction_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('stock_in')); ?>:</b>
	<?php echo CHtml::encode($data->stock_in); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stock_out')); ?>:</b>
	<?php echo CHtml::encode($data->stock_out); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notes')); ?>:</b>
	<?php echo CHtml::encode($data->notes); ?>
	<br />

	*/ ?>

</div>