<?php
/* @var $this VehicleCarSubDetailController */
/* @var $data VehicleCarSubDetail */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('assembly_year')); ?>:</b>
	<?php echo CHtml::encode($data->assembly_year); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transmission_id')); ?>:</b>
	<?php echo CHtml::encode($data->transmission_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fuel_type')); ?>:</b>
	<?php echo CHtml::encode($data->fuel_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('brand_id')); ?>:</b>
	<?php echo CHtml::encode($data->brand_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('sub_brand_id')); ?>:</b>
	<?php echo CHtml::encode($data->sub_brand_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('power_id')); ?>:</b>
	<?php echo CHtml::encode($data->power_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('drivetrain')); ?>:</b>
	<?php echo CHtml::encode($data->drivetrain); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('chasis_id')); ?>:</b>
	<?php echo CHtml::encode($data->chasis_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	*/ ?>

</div>