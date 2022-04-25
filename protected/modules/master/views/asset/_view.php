<?php
/* @var $this AssetController */
/* @var $data Asset */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('code')); ?>:</b>
	<?php echo CHtml::encode($data->code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('memo')); ?>:</b>
	<?php echo CHtml::encode($data->memo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_taxable')); ?>:</b>
	<?php echo CHtml::encode($data->is_taxable); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_zero_book_value')); ?>:</b>
	<?php echo CHtml::encode($data->is_zero_book_value); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('asset_category_id')); ?>:</b>
	<?php echo CHtml::encode($data->asset_category_id); ?>
	<br />

	*/ ?>

</div>