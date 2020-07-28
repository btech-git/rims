<?php
/* @var $this VehicleInspectionController */
/* @var $data VehicleInspection */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vehicle_id')); ?>:</b>
	<?php echo CHtml::encode($data->vehicle_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inspection_id')); ?>:</b>
	<?php echo CHtml::encode($data->inspection_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inspection_date')); ?>:</b>
	<?php echo CHtml::encode($data->inspection_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('work_order_number')); ?>:</b>
	<?php echo CHtml::encode($data->work_order_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />


</div>