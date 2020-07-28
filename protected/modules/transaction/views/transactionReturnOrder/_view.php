<?php
/* @var $this TransactionReturnOrderController */
/* @var $data TransactionReturnOrder */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('return_order_no')); ?>:</b>
	<?php echo CHtml::encode($data->return_order_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('return_order_date')); ?>:</b>
	<?php echo CHtml::encode($data->return_order_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('receive_item_id')); ?>:</b>
	<?php echo CHtml::encode($data->receive_item_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recipient_id')); ?>:</b>
	<?php echo CHtml::encode($data->recipient_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recipient_branch_id')); ?>:</b>
	<?php echo CHtml::encode($data->recipient_branch_id); ?>
	<br />


</div>