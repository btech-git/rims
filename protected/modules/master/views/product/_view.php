<?php
/* @var $this ProductController */
/* @var $data Product */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('code')); ?>:</b>
	<?php echo CHtml::encode($data->code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('manufacturer_code')); ?>:</b>
	<?php echo CHtml::encode($data->manufacturer_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('production_year')); ?>:</b>
	<?php echo CHtml::encode($data->production_year); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('extension')); ?>:</b>
	<?php echo CHtml::encode($data->extension); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('product_master_category_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_master_category_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_sub_master_category_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_sub_master_category_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_sub_category_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_sub_category_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_specification_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_specification_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vehicle_car_make_id')); ?>:</b>
	<?php echo CHtml::encode($data->vehicle_car_make_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vehicle_car_model_id')); ?>:</b>
	<?php echo CHtml::encode($data->vehicle_car_model_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('purchase_price')); ?>:</b>
	<?php echo CHtml::encode($data->purchase_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('recommended_selling_price')); ?>:</b>
	<?php echo CHtml::encode($data->recommended_selling_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hpp')); ?>:</b>
	<?php echo CHtml::encode($data->hpp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('retail_price')); ?>:</b>
	<?php echo CHtml::encode($data->retail_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stock')); ?>:</b>
	<?php echo CHtml::encode($data->stock); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('minimum_stock')); ?>:</b>
	<?php echo CHtml::encode($data->minimum_stock); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('margin_type')); ?>:</b>
	<?php echo CHtml::encode($data->margin_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('margin_amount')); ?>:</b>
	<?php echo CHtml::encode($data->margin_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_usable')); ?>:</b>
	<?php echo CHtml::encode($data->is_usable); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>