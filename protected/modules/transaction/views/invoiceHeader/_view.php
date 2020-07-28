<?php
/* @var $this InvoiceHeaderController */
/* @var $data InvoiceHeader */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_number')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invoice_date')); ?>:</b>
	<?php echo CHtml::encode($data->invoice_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('due_date')); ?>:</b>
	<?php echo CHtml::encode($data->due_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('reference_type')); ?>:</b>
	<?php echo CHtml::encode($data->reference_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sales_order_id')); ?>:</b>
	<?php echo CHtml::encode($data->sales_order_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('registration_transaction_id')); ?>:</b>
	<?php echo CHtml::encode($data->registration_transaction_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_id')); ?>:</b>
	<?php echo CHtml::encode($data->customer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vehicle_id')); ?>:</b>
	<?php echo CHtml::encode($data->vehicle_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ppn')); ?>:</b>
	<?php echo CHtml::encode($data->ppn); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pph')); ?>:</b>
	<?php echo CHtml::encode($data->pph); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('branch_id')); ?>:</b>
	<?php echo CHtml::encode($data->branch_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supervisor_id')); ?>:</b>
	<?php echo CHtml::encode($data->supervisor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('service_price')); ?>:</b>
	<?php echo CHtml::encode($data->service_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_price')); ?>:</b>
	<?php echo CHtml::encode($data->product_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pph_total')); ?>:</b>
	<?php echo CHtml::encode($data->pph_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ppn_total')); ?>:</b>
	<?php echo CHtml::encode($data->ppn_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_price')); ?>:</b>
	<?php echo CHtml::encode($data->total_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('in_words')); ?>:</b>
	<?php echo CHtml::encode($data->in_words); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	*/ ?>

</div>