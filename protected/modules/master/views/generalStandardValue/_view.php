<?php
/* @var $this GeneralStandardValueController */
/* @var $data GeneralStandardValue */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('difficulty')); ?>:</b>
	<?php echo CHtml::encode($data->difficulty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('difficulty_value')); ?>:</b>
	<?php echo CHtml::encode($data->difficulty_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('regular')); ?>:</b>
	<?php echo CHtml::encode($data->regular); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('luxury')); ?>:</b>
	<?php echo CHtml::encode($data->luxury); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('luxury_value')); ?>:</b>
	<?php echo CHtml::encode($data->luxury_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('luxury_calc')); ?>:</b>
	<?php echo CHtml::encode($data->luxury_calc); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('flat_rate_hour')); ?>:</b>
	<?php echo CHtml::encode($data->flat_rate_hour); ?>
	<br />

	*/ ?>

</div>