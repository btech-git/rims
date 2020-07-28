<?php
/* @var $this TransactionRequestOrderController */
/* @var $data TransactionRequestOrder */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('request_order_no')); ?>:</b>
	<?php echo CHtml::encode($data->request_order_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('request_order_date')); ?>:</b>
	<?php echo CHtml::encode($data->request_order_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('notes')); ?>:</b>
	<?php echo CHtml::encode($data->notes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total')); ?>:</b>
	<?php echo CHtml::encode($data->total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_items')); ?>:</b>
	<?php echo CHtml::encode($data->total_items); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approved_by')); ?>:</b>
	<?php echo CHtml::encode($data->approved_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approved_status')); ?>:</b>
	<?php echo CHtml::encode($data->approved_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('decline_memo')); ?>:</b>
	<?php echo CHtml::encode($data->decline_memo); ?>
	<br />

	*/ ?>

</div>