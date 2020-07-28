<?php
/* @var $this FindProductController */
/* @var $data Product */
?>

<div class="callout">
	<p>
		<?php echo CHTml::link(CHtml::encode($data->name), array('product/view', "id"=>$data->id)); ?>
		<br />
		Description of Product : <?php echo CHtml::encode($data->description); ?>
		<br />
		<?php echo CHtml::encode($data->productMasterCategory->name); ?> | 
		<?php echo CHtml::encode($data->productSubMasterCategory->name); ?> | 
		<?php echo CHtml::encode($data->brand->name); ?> | 
		<?php echo CHtml::encode($data->production_year); ?>
		<br />
		<?php echo CHtml::encode($data->manufacturer_code); ?>
	</p>
</div>