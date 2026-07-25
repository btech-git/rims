<?php
/* @var $this EmployeeExchangeDayoffController */
/* @var $data EmployeeExchangeDayoff */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_dayoff_old')); ?>:</b>
	<?php echo CHtml::encode($data->date_dayoff_old); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_dayoff_new')); ?>:</b>
	<?php echo CHtml::encode($data->date_dayoff_new); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employee_id')); ?>:</b>
	<?php echo CHtml::encode($data->employee_id); ?>
	<br />


</div>