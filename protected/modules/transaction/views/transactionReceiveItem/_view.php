<?php
/* @var $this TransactionReceiveItemController */
/* @var $data TransactionReceiveItem */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('receive_item_no')); ?>:</b>
	<?php echo CHtml::encode($data->receive_item_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('receive_item_date')); ?>:</b>
	<?php echo CHtml::encode($data->receive_item_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('arrival_date')); ?>:</b>
	<?php echo CHtml::encode($data->arrival_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recipient_id')); ?>:</b>
	<?php echo CHtml::encode($data->recipient_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recipient_branch_id')); ?>:</b>
	<?php echo CHtml::encode($data->recipient_branch_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('request_type')); ?>:</b>
	<?php echo CHtml::encode($data->request_type); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('request_code')); ?>:</b>
	<?php echo CHtml::encode($data->request_code); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_id')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_id); ?>
	<br />

	*/ ?>

</div>