<?php
/* @var $this CashTransactionController */
/* @var $data CashTransaction */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transaction_number')); ?>:</b>
	<?php echo CHtml::encode($data->transaction_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transaction_date')); ?>:</b>
	<?php echo CHtml::encode($data->transaction_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transaction_type')); ?>:</b>
	<?php echo CHtml::encode($data->transaction_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('coa_id')); ?>:</b>
	<?php echo CHtml::encode($data->coa_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('debit_amount')); ?>:</b>
	<?php echo CHtml::encode($data->debit_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('credit_amount')); ?>:</b>
	<?php echo CHtml::encode($data->credit_amount); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('branch_id')); ?>:</b>
	<?php echo CHtml::encode($data->branch_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	*/ ?>

</div>