<?php
/* @var $this ServicePricelistController */
/* @var $data ServicePricelist */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('service_id')); ?>:</b>
	<?php echo CHtml::encode($data->service_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('car_make_id')); ?>:</b>
	<?php echo CHtml::encode($data->car_make_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('car_model_id')); ?>:</b>
	<?php echo CHtml::encode($data->car_model_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('car_sub_detail_id')); ?>:</b>
	<?php echo CHtml::encode($data->car_sub_detail_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('difficulty')); ?>:</b>
	<?php echo CHtml::encode($data->difficulty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('difficulty_value')); ?>:</b>
	<?php echo CHtml::encode($data->difficulty_value); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('regular')); ?>:</b>
	<?php echo CHtml::encode($data->regular); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('luxury')); ?>:</b>
	<?php echo CHtml::encode($data->luxury); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('luxury_value')); ?>:</b>
	<?php echo CHtml::encode($data->luxury_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('luxury_calc')); ?>:</b>
	<?php echo CHtml::encode($data->luxury_calc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('standard_flat_rate_per_hour')); ?>:</b>
	<?php echo CHtml::encode($data->standard_flat_rate_per_hour); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('flat_rate_hour')); ?>:</b>
	<?php echo CHtml::encode($data->flat_rate_hour); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	*/ ?>

</div>