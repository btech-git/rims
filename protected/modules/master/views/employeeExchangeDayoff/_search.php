<?php
/* @var $this EmployeeExchangeDayoffController */
/* @var $model EmployeeExchangeDayoff */
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
		<?php echo $form->label($model,'date_dayoff_old'); ?>
		<?php echo $form->textField($model,'date_dayoff_old'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_dayoff_new'); ?>
		<?php echo $form->textField($model,'date_dayoff_new'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'employee_id'); ?>
		<?php echo $form->textField($model,'employee_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->