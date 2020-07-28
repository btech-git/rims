<?php
/* @var $this VehicleController */
/* @var $data Vehicle */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('plate_number')); ?>:</b>
	<?php echo CHtml::encode($data->plate_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('machine_number')); ?>:</b>
	<?php echo CHtml::encode($data->machine_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('frame_number')); ?>:</b>
	<?php echo CHtml::encode($data->frame_number); ?>
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

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('color_id')); ?>:</b>
	<?php echo CHtml::encode($data->color_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('year')); ?>:</b>
	<?php echo CHtml::encode($data->year); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_id')); ?>:</b>
	<?php echo CHtml::encode($data->customer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_pic_id')); ?>:</b>
	<?php echo CHtml::encode($data->customer_pic_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('chasis_id')); ?>:</b>
	<?php echo CHtml::encode($data->chasis_id); ?>
	<br />

	*/ ?>

</div>