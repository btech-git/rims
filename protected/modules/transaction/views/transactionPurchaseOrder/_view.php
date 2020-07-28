<?php
/* @var $this TransactionPurchaseOrderController */
/* @var $data TransactionPurchaseOrder */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('purchase_order_no')); ?>:</b>
	<?php echo CHtml::encode($data->purchase_order_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('purchase_order_date')); ?>:</b>
	<?php echo CHtml::encode($data->purchase_order_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('branch_issued')); ?>:</b>
	<?php echo CHtml::encode($data->branch_issued); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('supplier_id')); ?>:</b>
	<?php echo CHtml::encode($data->supplier_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estimation_date')); ?>:</b>
	<?php echo CHtml::encode($data->estimation_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_estimation_date')); ?>:</b>
	<?php echo CHtml::encode($data->payment_estimation_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('PPN')); ?>:</b>
	<?php echo CHtml::encode($data->PPN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subtotal')); ?>:</b>
	<?php echo CHtml::encode($data->subtotal); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('notes')); ?>:</b>
	<?php echo CHtml::encode($data->notes); ?>
	<br />

	*/ ?>

</div>