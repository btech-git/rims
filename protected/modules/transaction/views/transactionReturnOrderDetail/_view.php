<?php
/* @var $this TransactionReturnOrderDetailController */
/* @var $data TransactionReturnOrderDetail */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('return_order_id')); ?>:</b>
	<?php echo CHtml::encode($data->return_order_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty_request_left')); ?>:</b>
	<?php echo CHtml::encode($data->qty_request_left); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qty_reject')); ?>:</b>
	<?php echo CHtml::encode($data->qty_reject); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />


</div>