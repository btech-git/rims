<?php
/* @var $this EquipmentMaintenancesController */
/* @var $data EquipmentMaintenances */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('equipment_id')); ?>:</b>
	<?php echo CHtml::encode($data->equipment_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('equipment_task_id')); ?>:</b>
	<?php echo CHtml::encode($data->equipment_task_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('equipment_detail_id')); ?>:</b>
	<?php echo CHtml::encode($data->equipment_detail_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employee_id')); ?>:</b>
	<?php echo CHtml::encode($data->employee_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('maintenance_date')); ?>:</b>
	<?php echo CHtml::encode($data->maintenance_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('next_maintenance_date')); ?>:</b>
	<?php echo CHtml::encode($data->next_maintenance_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('check_date')); ?>:</b>
	<?php echo CHtml::encode($data->check_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('checked')); ?>:</b>
	<?php echo CHtml::encode($data->checked); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notes')); ?>:</b>
	<?php echo CHtml::encode($data->notes); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('equipment_condition')); ?>:</b>
	<?php echo CHtml::encode($data->equipment_condition); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>