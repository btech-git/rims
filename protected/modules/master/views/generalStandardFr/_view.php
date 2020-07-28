<?php
/* @var $this GeneralStandardFrController */
/* @var $data GeneralStandardFr */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('flat_rate')); ?>:</b>
	<?php echo CHtml::encode($data->flat_rate); ?>
	<br />


</div>