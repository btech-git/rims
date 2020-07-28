<?php
/* @var $this EmployeeAbsenceController */
/* @var $model EmployeeAbsence */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'employee-absence-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'employee_id'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'employee_id'); ?>
				<?php echo $form->error($model,'employee_id'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'month'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'month'); ?>
				<?php echo $form->error($model,'month'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'total_attendance'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'total_attendance'); ?>
				<?php echo $form->error($model,'total_attendance'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'absent'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'absent'); ?>
				<?php echo $form->error($model,'absent'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'bonus'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'bonus',array('size'=>18,'maxlength'=>18)); ?>
				<?php echo $form->error($model,'bonus'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'overtime'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'overtime'); ?>
				<?php echo $form->error($model,'overtime'); ?>
			</div>
		</div>
	</div>		

		<div class="field buttons text-center">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
		</div>
	</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->