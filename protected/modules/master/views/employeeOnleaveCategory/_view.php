<?php
/* @var $this EmployeeOnleaveCategoryController */
/* @var $data EmployeeOnleaveCategory */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('number_of_days')); ?>:</b>
	<?php echo CHtml::encode($data->number_of_days); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_using_quota')); ?>:</b>
	<?php echo CHtml::encode($data->is_using_quota); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_inactive')); ?>:</b>
	<?php echo CHtml::encode($data->is_inactive); ?>
	<br />


</div>