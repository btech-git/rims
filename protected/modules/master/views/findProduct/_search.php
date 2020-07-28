<?php
/* @var $this FindProductController */
/* @var $model Product */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'code'); ?>
		<?php echo $form->textField($model,'code',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'manufacturer_code'); ?>
		<?php echo $form->textField($model,'manufacturer_code',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'barcode'); ?>
		<?php echo $form->textField($model,'barcode',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'production_year'); ?>
		<?php echo $form->textField($model,'production_year'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'brand_id'); ?>
		<?php echo $form->textField($model,'brand_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'extension'); ?>
		<?php echo $form->textField($model,'extension',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_master_category_id'); ?>
		<?php echo $form->textField($model,'product_master_category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_sub_master_category_id'); ?>
		<?php echo $form->textField($model,'product_sub_master_category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'product_sub_category_id'); ?>
		<?php echo $form->textField($model,'product_sub_category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vehicle_car_make_id'); ?>
		<?php echo $form->textField($model,'vehicle_car_make_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vehicle_car_model_id'); ?>
		<?php echo $form->textField($model,'vehicle_car_model_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'purchase_price'); ?>
		<?php echo $form->textField($model,'purchase_price',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'recommended_selling_price'); ?>
		<?php echo $form->textField($model,'recommended_selling_price',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hpp'); ?>
		<?php echo $form->textField($model,'hpp',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'retail_price'); ?>
		<?php echo $form->textField($model,'retail_price',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'stock'); ?>
		<?php echo $form->textField($model,'stock'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'minimum_stock'); ?>
		<?php echo $form->textField($model,'minimum_stock'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'margin_type'); ?>
		<?php echo $form->textField($model,'margin_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'margin_amount'); ?>
		<?php echo $form->textField($model,'margin_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_usable'); ?>
		<?php echo $form->textField($model,'is_usable',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->