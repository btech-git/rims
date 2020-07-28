<?php
/* @var $this FindProductController */
/* @var $data Product */

// echo $keywordbold;
?>
<div class="callout">
	<p class="higlig">
		<?php echo CHTml::link(CHtml::encode($data->name), array('product/view', "id"=>$data->id)); ?>
		<br />
		<?php echo CHtml::encode($data->code); ?> | 
		<?php echo CHtml::encode($data->extension); ?>
		<br />
		<?php echo CHtml::encode($data->manufacturer_code); ?>
		<br />
		<?php echo CHtml::encode($data->description); ?>
	</p>
	<hr />
	<p class="higlig">
		<?php echo CHtml::encode($data->productMasterCategory->name); ?> | <?php echo CHtml::encode($data->productSubMasterCategory->name ); ?> | 
		<?php echo CHtml::encode($data->productSubCategory->name); ?>
	</p>
</div>