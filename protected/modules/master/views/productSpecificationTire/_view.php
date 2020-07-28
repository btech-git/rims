<?php
/* @var $this ProductSpecificationTireController */
/* @var $data ProductSpecificationTire */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('serial_number')); ?>:</b>
	<?php echo CHtml::encode($data->serial_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sub_brand_id')); ?>:</b>
	<?php echo CHtml::encode($data->sub_brand_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sub_brand_series_id')); ?>:</b>
	<?php echo CHtml::encode($data->sub_brand_series_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('attribute')); ?>:</b>
	<?php echo CHtml::encode($data->attribute); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('overall_diameter')); ?>:</b>
	<?php echo CHtml::encode($data->overall_diameter); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('section_width_inches')); ?>:</b>
	<?php echo CHtml::encode($data->section_width_inches); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('section_width_mm')); ?>:</b>
	<?php echo CHtml::encode($data->section_width_mm); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('aspect_ration')); ?>:</b>
	<?php echo CHtml::encode($data->aspect_ration); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('radial_type')); ?>:</b>
	<?php echo CHtml::encode($data->radial_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rim_diameter')); ?>:</b>
	<?php echo CHtml::encode($data->rim_diameter); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('load_index')); ?>:</b>
	<?php echo CHtml::encode($data->load_index); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('speed_symbol')); ?>:</b>
	<?php echo CHtml::encode($data->speed_symbol); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ply_rating')); ?>:</b>
	<?php echo CHtml::encode($data->ply_rating); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lettering')); ?>:</b>
	<?php echo CHtml::encode($data->lettering); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('terrain')); ?>:</b>
	<?php echo CHtml::encode($data->terrain); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('local_import')); ?>:</b>
	<?php echo CHtml::encode($data->local_import); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('car_type')); ?>:</b>
	<?php echo CHtml::encode($data->car_type); ?>
	<br />

	*/ ?>

</div>