<?php
/* @var $this RegistrationServiceController */
/* @var $model RegistrationService */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'registration-service-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'registration_transaction_id'); ?>
		<?php echo $form->textField($model,'registration_transaction_id'); ?>
		<?php echo $form->error($model,'registration_transaction_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'service_id'); ?>
		<?php echo $form->textField($model,'service_id'); ?>
		<?php echo $form->error($model,'service_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'employee_id'); ?>
		<?php echo $form->textField($model,'employee_id'); ?>
		<?php echo $form->error($model,'employee_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'claim'); ?>
		<?php echo $form->textField($model,'claim',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'claim'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'service_exception_rate'); ?>
		<?php echo $form->textField($model,'service_exception_rate',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'service_exception_rate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_price'); ?>
		<?php echo $form->textField($model,'total_price',array('size'=>18,'maxlength'=>18)); ?>
		<?php echo $form->error($model,'total_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hour'); ?>
		<?php echo $form->textField($model,'hour',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'hour'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->