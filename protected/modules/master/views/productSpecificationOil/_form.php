<?php
/* @var $this ProductSpecificationOilController */
/* @var $model ProductSpecificationOil */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-specification-oil-form',
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
		<?php echo $form->labelEx($model,'category_usage'); ?>
		<?php echo $form->textField($model,'category_usage',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'category_usage'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'oil_type'); ?>
		<?php echo $form->textField($model,'oil_type',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'oil_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'transmission'); ?>
		<?php echo $form->textField($model,'transmission'); ?>
		<?php echo $form->error($model,'transmission'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'code_serial'); ?>
		<?php echo $form->textField($model,'code_serial',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'code_serial'); ?>
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
		<?php echo $form->labelEx($model,'fuel'); ?>
		<?php echo $form->textField($model,'fuel',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'fuel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dot_code'); ?>
		<?php echo $form->textField($model,'dot_code'); ?>
		<?php echo $form->error($model,'dot_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'viscosity_low_t'); ?>
		<?php echo $form->textField($model,'viscosity_low_t',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'viscosity_low_t'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'viscosity_high'); ?>
		<?php echo $form->textField($model,'viscosity_high',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'viscosity_high'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'api_code'); ?>
		<?php echo $form->textField($model,'api_code',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'api_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'size_measurements'); ?>
		<?php echo $form->textField($model,'size_measurements',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'size_measurements'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'size'); ?>
		<?php echo $form->textField($model,'size',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'size'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'car_use'); ?>
		<?php echo $form->textArea($model,'car_use',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'car_use'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->