<?php
/* @var $this AssetDepreciationController */
/* @var $data AssetDepreciation */
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount')); ?>:</b>
	<?php echo CHtml::encode($data->amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('number_of_month')); ?>:</b>
	<?php echo CHtml::encode($data->number_of_month); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('asset_id')); ?>:</b>
	<?php echo CHtml::encode($data->asset_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	*/ ?>

</div>