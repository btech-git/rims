<?php
/* @var $this MovementInDetailController */
/* @var $data MovementInDetail */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('receive_item_detail_id')); ?>:</b>
	<?php echo CHtml::encode($data->receive_item_detail_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('movement_in_header_id')); ?>:</b>
	<?php echo CHtml::encode($data->movement_in_header_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity_transaction')); ?>:</b>
	<?php echo CHtml::encode($data->quantity_transaction); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('warehouse_id')); ?>:</b>
	<?php echo CHtml::encode($data->warehouse_id); ?>
	<br />


</div>