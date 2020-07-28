<?php
/* @var $this EmployeeAbsenceController */
/* @var $model EmployeeAbsence */
/* @var $form CActiveForm */
?>

<div class="wide form" id="advSearch">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'id', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'id'); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'employee_id', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'employee_id'); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'month', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'month'); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'total_attendance', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'total_attendance'); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'absent', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'absent'); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'bonus', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'bonus',array('size'=>18,'maxlength'=>18)); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'overtime', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'overtime'); ?>
				</div>
			</div>
		</div>	

		<div class="field buttons text-right">
			<?php echo CHtml::submitButton('Search',array('class'=>'button cbutton')); ?>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>

</div><!-- search-form -->