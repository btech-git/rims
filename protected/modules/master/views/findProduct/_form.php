<?php
/* @var $this FindProductController */
/* @var $model Product */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'code'); ?>
		<?php echo $form->textField($model,'code',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'manufacturer_code'); ?>
		<?php echo $form->textField($model,'manufacturer_code',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'manufacturer_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'barcode'); ?>
		<?php echo $form->textField($model,'barcode',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'barcode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'production_year'); ?>
		<?php echo $form->textField($model,'production_year'); ?>
		<?php echo $form->error($model,'production_year'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'brand_id'); ?>
		<?php echo $form->textField($model,'brand_id'); ?>
		<?php echo $form->error($model,'brand_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'extension'); ?>
		<?php echo $form->textField($model,'extension',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'extension'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_master_category_id'); ?>
		<?php echo $form->textField($model,'product_master_category_id'); ?>
		<?php echo $form->error($model,'product_master_category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_sub_master_category_id'); ?>
		<?php echo $form->textField($model,'product_sub_master_category_id'); ?>
		<?php echo $form->error($model,'product_sub_master_category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_sub_category_id'); ?>
		<?php echo $form->textField($model,'product_sub_category_id'); ?>
		<?php echo $form->error($model,'product_sub_category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vehicle_car_make_id'); ?>
		<?php echo $form->textField($model,'vehicle_car_make_id'); ?>
		<?php echo $form->error($model,'vehicle_car_make_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vehicle_car_model_id'); ?>
		<?php echo $form->textField($model,'vehicle_car_model_id'); ?>
		<?php echo $form->error($model,'vehicle_car_model_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'purchase_price'); ?>
		<?php echo $form->textField($model,'purchase_price',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'purchase_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'recommended_selling_price'); ?>
		<?php echo $form->textField($model,'recommended_selling_price',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'recommended_selling_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hpp'); ?>
		<?php echo $form->textField($model,'hpp',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'hpp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'retail_price'); ?>
		<?php echo $form->textField($model,'retail_price',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'retail_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'stock'); ?>
		<?php echo $form->textField($model,'stock'); ?>
		<?php echo $form->error($model,'stock'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'minimum_stock'); ?>
		<?php echo $form->textField($model,'minimum_stock'); ?>
		<?php echo $form->error($model,'minimum_stock'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'margin_type'); ?>
		<?php echo $form->textField($model,'margin_type'); ?>
		<?php echo $form->error($model,'margin_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'margin_amount'); ?>
		<?php echo $form->textField($model,'margin_amount'); ?>
		<?php echo $form->error($model,'margin_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_usable'); ?>
		<?php echo $form->textField($model,'is_usable',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'is_usable'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->