<?php
/* @var $this InspectionChecklistTypeModuleController */
/* @var $model InspectionChecklistTypeModule */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'inspection-checklist-type-module-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'inspection_type_id'); ?>
		<?php echo $form->textField($model,'inspection_type_id'); ?>
		<?php echo $form->error($model,'inspection_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'inspection_module_id'); ?>
		<?php echo $form->textField($model,'inspection_module_id'); ?>
		<?php echo $form->error($model,'inspection_module_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->