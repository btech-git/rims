<?php
/* @var $this InspectionChecklistTypeModuleController */
/* @var $data InspectionChecklistTypeModule */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inspection_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->inspection_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('inspection_module_id')); ?>:</b>
	<?php echo CHtml::encode($data->inspection_module_id); ?>
	<br />


</div>