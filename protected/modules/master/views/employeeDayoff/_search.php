<?php
/* @var $this EmployeeDayoffController */
/* @var $model EmployeeDayoff */
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
					<?php echo $form->label($model,'day', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'day'); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'notes', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'date_from', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'date_from'); ?>
				</div>
			</div>
		</div>	

		<!-- BEGIN FIELDS -->
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($model,'date_to', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($model,'date_to'); ?>
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