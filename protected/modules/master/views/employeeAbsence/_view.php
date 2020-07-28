<?php
/* @var $this EmployeeAbsenceController */
/* @var $data EmployeeAbsence */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employee_id')); ?>:</b>
	<?php echo CHtml::encode($data->employee_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('month')); ?>:</b>
	<?php echo CHtml::encode($data->month); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_attendance')); ?>:</b>
	<?php echo CHtml::encode($data->total_attendance); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('absent')); ?>:</b>
	<?php echo CHtml::encode($data->absent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bonus')); ?>:</b>
	<?php echo CHtml::encode($data->bonus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('overtime')); ?>:</b>
	<?php echo CHtml::encode($data->overtime); ?>
	<br />


</div>