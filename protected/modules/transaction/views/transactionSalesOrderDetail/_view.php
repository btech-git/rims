<?php
/* @var $this TransactionSalesOrderDetailController */
/* @var $data TransactionSalesOrderDetail */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sales_order_id')); ?>:</b>
	<?php echo CHtml::encode($data->sales_order_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unit_id')); ?>:</b>
	<?php echo CHtml::encode($data->unit_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('retail_price')); ?>:</b>
	<?php echo CHtml::encode($data->retail_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unit_price')); ?>:</b>
	<?php echo CHtml::encode($data->unit_price); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('amount')); ?>:</b>
	<?php echo CHtml::encode($data->amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount_step')); ?>:</b>
	<?php echo CHtml::encode($data->discount_step); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount1_type')); ?>:</b>
	<?php echo CHtml::encode($data->discount1_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount1_nominal')); ?>:</b>
	<?php echo CHtml::encode($data->discount1_nominal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount1_temp_quantity')); ?>:</b>
	<?php echo CHtml::encode($data->discount1_temp_quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount1_temp_price')); ?>:</b>
	<?php echo CHtml::encode($data->discount1_temp_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount2_type')); ?>:</b>
	<?php echo CHtml::encode($data->discount2_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount2_nominal')); ?>:</b>
	<?php echo CHtml::encode($data->discount2_nominal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount2_temp_quantity')); ?>:</b>
	<?php echo CHtml::encode($data->discount2_temp_quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount2_temp_price')); ?>:</b>
	<?php echo CHtml::encode($data->discount2_temp_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount3_type')); ?>:</b>
	<?php echo CHtml::encode($data->discount3_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount3_nominal')); ?>:</b>
	<?php echo CHtml::encode($data->discount3_nominal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount3_temp_quantity')); ?>:</b>
	<?php echo CHtml::encode($data->discount3_temp_quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount3_temp_price')); ?>:</b>
	<?php echo CHtml::encode($data->discount3_temp_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount4_type')); ?>:</b>
	<?php echo CHtml::encode($data->discount4_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount4_nominal')); ?>:</b>
	<?php echo CHtml::encode($data->discount4_nominal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount4_temp_quantity')); ?>:</b>
	<?php echo CHtml::encode($data->discount4_temp_quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount4_temp_price')); ?>:</b>
	<?php echo CHtml::encode($data->discount4_temp_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount5_type')); ?>:</b>
	<?php echo CHtml::encode($data->discount5_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount5_nominal')); ?>:</b>
	<?php echo CHtml::encode($data->discount5_nominal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount5_temp_quantity')); ?>:</b>
	<?php echo CHtml::encode($data->discount5_temp_quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discount5_temp_price')); ?>:</b>
	<?php echo CHtml::encode($data->discount5_temp_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_quantity')); ?>:</b>
	<?php echo CHtml::encode($data->total_quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_price')); ?>:</b>
	<?php echo CHtml::encode($data->total_price); ?>
	<br />

	*/ ?>

</div>