<?php
/* @var $this ProductSpecificationTireController */
/* @var $model ProductSpecificationTire */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-specification-tire-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'product_id'); ?>
		<?php echo $form->textField($model,'product_id'); ?>
		<?php echo $form->error($model,'product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'serial_number'); ?>
		<?php echo $form->textField($model,'serial_number',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'serial_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sub_brand_id'); ?>
		<?php echo $form->textField($model,'sub_brand_id'); ?>
		<?php echo $form->error($model,'sub_brand_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sub_brand_series_id'); ?>
		<?php echo $form->textField($model,'sub_brand_series_id'); ?>
		<?php echo $form->error($model,'sub_brand_series_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'attribute'); ?>
		<?php echo $form->textField($model,'attribute',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'attribute'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'overall_diameter'); ?>
		<?php echo $form->textField($model,'overall_diameter'); ?>
		<?php echo $form->error($model,'overall_diameter'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'section_width_inches'); ?>
		<?php echo $form->textField($model,'section_width_inches'); ?>
		<?php echo $form->error($model,'section_width_inches'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'section_width_mm'); ?>
		<?php echo $form->textField($model,'section_width_mm'); ?>
		<?php echo $form->error($model,'section_width_mm'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'aspect_ration'); ?>
		<?php echo $form->textField($model,'aspect_ration'); ?>
		<?php echo $form->error($model,'aspect_ration'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'radial_type'); ?>
		<?php echo $form->textField($model,'radial_type',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'radial_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rim_diameter'); ?>
		<?php echo $form->textField($model,'rim_diameter'); ?>
		<?php echo $form->error($model,'rim_diameter'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'load_index'); ?>
		<?php echo $form->textField($model,'load_index'); ?>
		<?php echo $form->error($model,'load_index'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'speed_symbol'); ?>
		<?php echo $form->textField($model,'speed_symbol',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'speed_symbol'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ply_rating'); ?>
		<?php echo $form->textField($model,'ply_rating'); ?>
		<?php echo $form->error($model,'ply_rating'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lettering'); ?>
		<?php echo $form->textField($model,'lettering',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'lettering'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'terrain'); ?>
		<?php echo $form->textField($model,'terrain',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'terrain'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'local_import'); ?>
		<?php echo $form->textField($model,'local_import',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'local_import'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'car_type'); ?>
		<?php echo $form->textField($model,'car_type',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'car_type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->