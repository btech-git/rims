<?php
/* @var $this VehicleCarSubModelDetailController */
/* @var $data VehicleCarSubModelDetail */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('car_make_id')); ?>:</b>
	<?php echo CHtml::encode($data->car_make_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('car_model_id')); ?>:</b>
	<?php echo CHtml::encode($data->car_model_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('car_sub_model_id')); ?>:</b>
	<?php echo CHtml::encode($data->car_sub_model_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('chasis_code')); ?>:</b>
	<?php echo CHtml::encode($data->chasis_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('assembly_year_start')); ?>:</b>
	<?php echo CHtml::encode($data->assembly_year_start); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('assembly_year_end')); ?>:</b>
	<?php echo CHtml::encode($data->assembly_year_end); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transmission')); ?>:</b>
	<?php echo CHtml::encode($data->transmission); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fuel_type')); ?>:</b>
	<?php echo CHtml::encode($data->fuel_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('power')); ?>:</b>
	<?php echo CHtml::encode($data->power); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('drivetrain')); ?>:</b>
	<?php echo CHtml::encode($data->drivetrain); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('luxury_value')); ?>:</b>
	<?php echo CHtml::encode($data->luxury_value); ?>
	<br />

	*/ ?>

</div>