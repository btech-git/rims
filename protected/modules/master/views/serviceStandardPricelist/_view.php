<?php
/* @var $this ServiceStandardPricelistController */
/* @var $data ServiceStandardPricelist */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('service_id')); ?>:</b>
	<?php echo CHtml::encode($data->service_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('difficulty')); ?>:</b>
	<?php echo CHtml::encode($data->difficulty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('difficulty_value')); ?>:</b>
	<?php echo CHtml::encode($data->difficulty_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('regular')); ?>:</b>
	<?php echo CHtml::encode($data->regular); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('luxury')); ?>:</b>
	<?php echo CHtml::encode($data->luxury); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('luxury_value')); ?>:</b>
	<?php echo CHtml::encode($data->luxury_value); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('luxury_calc')); ?>:</b>
	<?php echo CHtml::encode($data->luxury_calc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('standard_rate_per_hour')); ?>:</b>
	<?php echo CHtml::encode($data->standard_rate_per_hour); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('flat_rate_hour')); ?>:</b>
	<?php echo CHtml::encode($data->flat_rate_hour); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('common_price')); ?>:</b>
	<?php echo CHtml::encode($data->common_price); ?>
	<br />

	*/ ?>

</div>