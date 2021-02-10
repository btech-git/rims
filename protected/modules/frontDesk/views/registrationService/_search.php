<?php
/* @var $this RegistrationServiceController */
/* @var $model RegistrationService */
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
		<?php echo $form->label($model,'registration_transaction_id'); ?>
		<?php echo $form->textField($model,'registration_transaction_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'service_id'); ?>
		<?php echo $form->textField($model,'service_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'claim'); ?>
		<?php echo $form->textField($model,'claim',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price'); ?>
		<?php echo $form->textField($model,'price',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_price'); ?>
		<?php echo $form->textField($model,'total_price',array('size'=>18,'maxlength'=>18)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'discount_price'); ?>
		<?php echo $form->textField($model,'discount_price',array('size'=>18,'maxlength'=>18)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'discount_type'); ?>
		<?php echo $form->textField($model,'discount_type',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_quick_service'); ?>
		<?php echo $form->textField($model,'is_quick_service'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'start'); ?>
		<?php echo $form->textField($model,'start'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'end'); ?>
		<?php echo $form->textField($model,'end'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pause'); ?>
		<?php echo $form->textField($model,'pause'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'resume'); ?>
		<?php echo $form->textField($model,'resume'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pause_time'); ?>
		<?php echo $form->textField($model,'pause_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total_time'); ?>
		<?php echo $form->textField($model,'total_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_body_repair'); ?>
		<?php echo $form->textField($model,'is_body_repair'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'start_mechanic_id'); ?>
		<?php echo $form->textField($model,'start_mechanic_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'finish_mechanic_id'); ?>
		<?php echo $form->textField($model,'finish_mechanic_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pause_mechanic_id'); ?>
		<?php echo $form->textField($model,'pause_mechanic_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'resume_mechanic_id'); ?>
		<?php echo $form->textField($model,'resume_mechanic_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'supervisor_id'); ?>
		<?php echo $form->textField($model,'supervisor_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->