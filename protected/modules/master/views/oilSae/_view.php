<?php
/* @var $this OilSaeController */
/* @var $data OilSae */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('winter_grade')); ?>:</b>
	<?php echo CHtml::encode($data->winter_grade); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hot_grade')); ?>:</b>
	<?php echo CHtml::encode($data->hot_grade); ?>
	<br />
</div>