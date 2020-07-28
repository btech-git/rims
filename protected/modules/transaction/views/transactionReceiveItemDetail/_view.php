<?php
/* @var $this TransactionReceiveItemDetailController */
/* @var $data TransactionReceiveItemDetail */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('receive_item_id')); ?>:</b>
	<?php echo CHtml::encode($data->receive_item_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty_request')); ?>:</b>
	<?php echo CHtml::encode($data->qty_request); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty_good')); ?>:</b>
	<?php echo CHtml::encode($data->qty_good); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty_reject')); ?>:</b>
	<?php echo CHtml::encode($data->qty_reject); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty_more')); ?>:</b>
	<?php echo CHtml::encode($data->qty_more); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty_request_left')); ?>:</b>
	<?php echo CHtml::encode($data->qty_request_left); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('barcode_product')); ?>:</b>
	<?php echo CHtml::encode($data->barcode_product); ?>
	<br />

	*/ ?>

</div>