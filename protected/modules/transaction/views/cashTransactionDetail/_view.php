<?php
/* @var $this CashTransactionDetailController */
/* @var $data CashTransactionDetail */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cash_transaction_id')); ?>:</b>
	<?php echo CHtml::encode($data->cash_transaction_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('coa_id')); ?>:</b>
	<?php echo CHtml::encode($data->coa_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount')); ?>:</b>
	<?php echo CHtml::encode($data->amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notes')); ?>:</b>
	<?php echo CHtml::encode($data->notes); ?>
	<br />


</div>