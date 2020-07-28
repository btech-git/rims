<?php
/* @var $this RegistrationServiceController */
/* @var $registrationService RegistrationService */
/* @var $form CActiveForm */
?>

<div class="wide form" id="advSearch">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<div class="row">
	<div class="small-12 medium-6 columns">
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($registrationService,'service_id', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($registrationService,'service_id'); ?>
				</div>
			</div>
		</div>

		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($registrationService,'start', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($registrationService,'start'); ?>
				</div>
			</div>
		</div>

		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($registrationService,'end', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($registrationService,'end'); ?>
				</div>
			</div>
		</div>

		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($registrationService,'pause', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($registrationService,'pause'); ?>
				</div>
			</div>
		</div>

		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($registrationService,'resume', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($registrationService,'resume'); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="small-12 medium-6 columns">
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($registrationService,'pause_time', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($registrationService,'pause_time'); ?>
				</div>
			</div>
		</div>

		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<?php echo $form->label($registrationService,'total_time', array('class'=>'prefix')); ?>
				</div>
				<div class="small-8 columns">
					<?php echo $form->textField($registrationService,'total_time'); ?>
				</div>
			</div>
		</div>

		<div class="row buttons text-right">
			<?php echo CHtml::submitButton('Search', array('class'=>'button cbutton')); ?>
		</div>
	</div>

	<!-- <div class="row">
		<?php //echo $form->label($registrationService,'registration_transaction_id'); ?>
		<?php //echo $form->textField($registrationService,'registration_transaction_id'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($registrationService,'service_id'); ?>
		<?php //echo $form->textField($registrationService,'service_id'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($registrationService,'claim'); ?>
		<?php //echo $form->textField($registrationService,'claim',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($registrationService,'price'); ?>
		<?php //echo $form->textField($registrationService,'price',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($registrationService,'total_price'); ?>
		<?php //echo $form->textField($registrationService,'total_price',array('size'=>18,'maxlength'=>18)); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($registrationService,'discount_price'); ?>
		<?php //echo $form->textField($registrationService,'discount_price',array('size'=>18,'maxlength'=>18)); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($registrationService,'discount_type'); ?>
		<?php //echo $form->textField($registrationService,'discount_type',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($registrationService,'is_quick_service'); ?>
		<?php //echo $form->textField($registrationService,'is_quick_service'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($registrationService,'start'); ?>
		<?php //echo $form->textField($registrationService,'start'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($registrationService,'end'); ?>
		<?php //echo $form->textField($registrationService,'end'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($registrationService,'pause'); ?>
		<?php //echo $form->textField($registrationService,'pause'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($registrationService,'resume'); ?>
		<?php //echo $form->textField($registrationService,'resume'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($registrationService,'pause_time'); ?>
		<?php //echo $form->textField($registrationService,'pause_time'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($registrationService,'total_time'); ?>
		<?php //echo $form->textField($registrationService,'total_time'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($registrationService,'note'); ?>
		<?php //echo $form->textArea($registrationService,'note',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($registrationService,'is_body_repair'); ?>
		<?php //echo $form->textField($registrationService,'is_body_repair'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($registrationService,'status'); ?>
		<?php //echo $form->textField($registrationService,'status',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($registrationService,'start_mechanic_id'); ?>
		<?php //echo $form->textField($registrationService,'start_mechanic_id'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($registrationService,'finish_mechanic_id'); ?>
		<?php //echo $form->textField($registrationService,'finish_mechanic_id'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($registrationService,'pause_mechanic_id'); ?>
		<?php //echo $form->textField($registrationService,'pause_mechanic_id'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($registrationService,'resume_mechanic_id'); ?>
		<?php //echo $form->textField($registrationService,'resume_mechanic_id'); ?>
	</div>

	<div class="row">
		<?php //echo $form->label($registrationService,'supervisor_id'); ?>
		<?php //echo $form->textField($registrationService,'supervisor_id'); ?>
	</div> -->

	<!-- <div class="row buttons">
		<?php //echo CHtml::submitButton('Search'); ?>
	</div> -->

<?php $this->endWidget(); ?>

</div><!-- search-form -->