<?php
/* @var $this RegistrationTransactionController */
/* @var $data RegistrationTransaction */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transaction_number')); ?>:</b>
	<?php echo CHtml::encode($data->transaction_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('trasaction_date')); ?>:</b>
	<?php echo CHtml::encode($data->trasaction_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('repair_type')); ?>:</b>
	<?php echo CHtml::encode($data->repair_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('problem')); ?>:</b>
	<?php echo CHtml::encode($data->problem); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_id')); ?>:</b>
	<?php echo CHtml::encode($data->customer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pic_id')); ?>:</b>
	<?php echo CHtml::encode($data->pic_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('vehicle_id')); ?>:</b>
	<?php echo CHtml::encode($data->vehicle_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('branch_id')); ?>:</b>
	<?php echo CHtml::encode($data->branch_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_quickservice')); ?>:</b>
	<?php echo CHtml::encode($data->total_quickservice); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_quickservice_price')); ?>:</b>
	<?php echo CHtml::encode($data->total_quickservice_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_service')); ?>:</b>
	<?php echo CHtml::encode($data->total_service); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subtotal_service')); ?>:</b>
	<?php echo CHtml::encode($data->subtotal_service); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount_service')); ?>:</b>
	<?php echo CHtml::encode($data->discount_service); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_service_price')); ?>:</b>
	<?php echo CHtml::encode($data->total_service_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_product')); ?>:</b>
	<?php echo CHtml::encode($data->total_product); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subtotal_product')); ?>:</b>
	<?php echo CHtml::encode($data->subtotal_product); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount_product')); ?>:</b>
	<?php echo CHtml::encode($data->discount_product); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_product_price')); ?>:</b>
	<?php echo CHtml::encode($data->total_product_price); ?>
	<br />

	*/ ?>

</div>