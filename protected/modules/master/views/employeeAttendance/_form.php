<?php
/* @var $this EmployeeAttendanceController */
/* @var $model EmployeeAttendance */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'employee-attendance-form',
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
				<?php echo $form->labelEx($model,'user_id'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'user_id'); ?>
				<?php echo $form->error($model,'user_id'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'date'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'date'); ?>
				<?php echo $form->error($model,'date'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'login_time'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'login_time'); ?>
				<?php echo $form->error($model,'login_time'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'logout_time'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'logout_time'); ?>
				<?php echo $form->error($model,'logout_time'); ?>
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