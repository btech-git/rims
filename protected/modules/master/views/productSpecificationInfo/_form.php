<?php
/* @var $this ProductSpecificationInfoController */
/* @var $model ProductSpecificationInfo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-specification-info-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'product_specification_type_id'); ?>
		<?php echo $form->textField($model,'product_specification_type_id'); ?>
		<?php echo $form->dropDownList($model, 'product_specification_type_id', CHtml::listData(ProductSpecificationType::model()->findAll(), 'id', 'name'),array(
            	'prompt' => '[--Select Product Specification Type--]',
              	/*'onchange'=> 'jQuery.ajax({
		              	type: "POST",
		              	//dataType: "JSON",
		              	url: "' . CController::createUrl('ajaxGetCity',array('province'=>'')) . '" + jQuery(this).val(),
		              	data: jQuery("form").serialize(),
		              	success: function(data){
		                console.log(data);
		                jQuery("#Employee_city_id").html(data);
              		},
            	});'*/
      	)); ?>
		<?php echo $form->error($model,'product_specification_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->