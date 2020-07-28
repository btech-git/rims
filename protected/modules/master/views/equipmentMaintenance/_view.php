<?php
/* @var $this EquipmentMaintenanceController */
/* @var $data EquipmentMaintenance */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('equipment_task_id')); ?>:</b>
	<?php echo CHtml::encode($data->equipment_task_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('equipment_branch_id')); ?>:</b>
	<?php echo CHtml::encode($data->equipment_branch_id); ?>
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


</div>