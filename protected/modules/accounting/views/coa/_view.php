<?php
/* @var $this CoaController */
/* @var $data Coa */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('code')); ?>:</b>
	<?php echo CHtml::encode($data->code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('coa_category_id')); ?>:</b>
	<?php echo CHtml::encode($data->coa_category_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('coa_sub_category_id')); ?>:</b>
	<?php echo CHtml::encode($data->coa_sub_category_id); ?>
	<br />


</div>