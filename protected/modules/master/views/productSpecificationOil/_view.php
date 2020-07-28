<?php
/* @var $this ProductSpecificationOilController */
/* @var $data ProductSpecificationOil */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_usage')); ?>:</b>
	<?php echo CHtml::encode($data->category_usage); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oil_type')); ?>:</b>
	<?php echo CHtml::encode($data->oil_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('transmission')); ?>:</b>
	<?php echo CHtml::encode($data->transmission); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('code_serial')); ?>:</b>
	<?php echo CHtml::encode($data->code_serial); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sub_brand_id')); ?>:</b>
	<?php echo CHtml::encode($data->sub_brand_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('sub_brand_series_id')); ?>:</b>
	<?php echo CHtml::encode($data->sub_brand_series_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fuel')); ?>:</b>
	<?php echo CHtml::encode($data->fuel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dot_code')); ?>:</b>
	<?php echo CHtml::encode($data->dot_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('viscosity_low_t')); ?>:</b>
	<?php echo CHtml::encode($data->viscosity_low_t); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('viscosity_high')); ?>:</b>
	<?php echo CHtml::encode($data->viscosity_high); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('api_code')); ?>:</b>
	<?php echo CHtml::encode($data->api_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('size_measurements')); ?>:</b>
	<?php echo CHtml::encode($data->size_measurements); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('size')); ?>:</b>
	<?php echo CHtml::encode($data->size); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('car_use')); ?>:</b>
	<?php echo CHtml::encode($data->car_use); ?>
	<br />

	*/ ?>

</div>