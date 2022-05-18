<?php
/* @var $this AssetPurchaseController */
/* @var $data AssetPurchase */
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('transaction_time')); ?>:</b>
	<?php echo CHtml::encode($data->transaction_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('purchase_value')); ?>:</b>
	<?php echo CHtml::encode($data->purchase_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('monthly_useful_life')); ?>:</b>
	<?php echo CHtml::encode($data->monthly_useful_life); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('depreciation_amount')); ?>:</b>
	<?php echo CHtml::encode($data->depreciation_amount); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('depreciation_start_date')); ?>:</b>
	<?php echo CHtml::encode($data->depreciation_start_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('depreciation_end_date')); ?>:</b>
	<?php echo CHtml::encode($data->depreciation_end_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('asset_id')); ?>:</b>
	<?php echo CHtml::encode($data->asset_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	*/ ?>

</div>