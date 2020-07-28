<?php
/* @var $this ConsignmentInHeaderController */
/* @var $data ConsignmentInHeader */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('consignment_in_number')); ?>:</b>
	<?php echo CHtml::encode($data->consignment_in_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_posting')); ?>:</b>
	<?php echo CHtml::encode($data->date_posting); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_document')); ?>:</b>
	<?php echo CHtml::encode($data->status_document); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_id')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_arrival')); ?>:</b>
	<?php echo CHtml::encode($data->date_arrival); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('receive_id')); ?>:</b>
	<?php echo CHtml::encode($data->receive_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('receive_branch')); ?>:</b>
	<?php echo CHtml::encode($data->receive_branch); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_price')); ?>:</b>
	<?php echo CHtml::encode($data->total_price); ?>
	<br />

	*/ ?>

</div>