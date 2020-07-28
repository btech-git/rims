<?php
/* @var $this SectionController */
/* @var $data Section */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('code')); ?>:</b>
	<?php echo CHtml::encode($data->code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rack_number')); ?>:</b>
	<?php echo CHtml::encode($data->rack_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('column')); ?>:</b>
	<?php echo CHtml::encode($data->column); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('row')); ?>:</b>
	<?php echo CHtml::encode($data->row); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />


</div>