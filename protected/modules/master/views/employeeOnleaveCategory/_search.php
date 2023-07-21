<?php
/* @var $this EmployeeOnleaveCategoryController */
/* @var $model EmployeeOnleaveCategory */
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
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>60)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'number_of_days'); ?>
		<?php echo $form->textField($model,'number_of_days'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_using_quota'); ?>
		<?php echo $form->textField($model,'is_using_quota'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_inactive'); ?>
		<?php echo $form->textField($model,'is_inactive'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->