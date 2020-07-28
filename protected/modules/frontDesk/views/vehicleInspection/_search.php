<?php
/* @var $this VehicleInspectionController */
/* @var $model VehicleInspection */
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
		<?php echo $form->label($model,'vehicle_id'); ?>
		<?php echo $form->textField($model,'vehicle_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'inspection_id'); ?>
		<?php echo $form->textField($model,'inspection_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'inspection_date'); ?>
		<?php echo $form->textField($model,'inspection_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'work_order_number'); ?>
		<?php echo $form->textField($model,'work_order_number',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->