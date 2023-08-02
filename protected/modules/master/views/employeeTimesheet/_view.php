<?php
/* @var $this EmployeeTimesheetController */
/* @var $data EmployeeTimesheet */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clock_in')); ?>:</b>
	<?php echo CHtml::encode($data->clock_in); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clock_out')); ?>:</b>
	<?php echo CHtml::encode($data->clock_out); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employee_id')); ?>:</b>
	<?php echo CHtml::encode($data->employee_id); ?>
	<br />


</div>