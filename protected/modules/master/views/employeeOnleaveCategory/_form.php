<?php
/* @var $this EmployeeOnleaveCategoryController */
/* @var $model EmployeeOnleaveCategory */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'employee-onleave-category-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>60)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'number_of_days'); ?>
		<?php echo $form->textField($model,'number_of_days'); ?>
		<?php echo $form->error($model,'number_of_days'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_using_quota'); ?>
		<?php echo $form->textField($model,'is_using_quota'); ?>
		<?php echo $form->error($model,'is_using_quota'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_inactive'); ?>
		<?php echo $form->textField($model,'is_inactive'); ?>
		<?php echo $form->error($model,'is_inactive'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->