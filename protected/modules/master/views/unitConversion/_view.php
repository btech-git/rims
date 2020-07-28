<?php
/* @var $this UnitConversionController */
/* @var $data UnitConversion */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unit_from_id')); ?>:</b>
	<?php echo CHtml::encode($data->unit_from_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unit_to_id')); ?>:</b>
	<?php echo CHtml::encode($data->unit_to_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('multiplier')); ?>:</b>
	<?php echo CHtml::encode($data->multiplier); ?>
	<br />


</div>