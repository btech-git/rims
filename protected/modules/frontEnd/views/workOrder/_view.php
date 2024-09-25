<?php
/* @var $this WorkOrderController */
/* @var $data WorkOrder */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('work_order_number')); ?>:</b>
	<?php echo CHtml::encode($data->work_order_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('work_order_date')); ?>:</b>
	<?php echo CHtml::encode($data->work_order_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('registration_transaction_id')); ?>:</b>
	<?php echo CHtml::encode($data->registration_transaction_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('branch_id')); ?>:</b>
	<?php echo CHtml::encode($data->branch_id); ?>
	<br />


</div>