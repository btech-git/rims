<?php
/* @var $this AssetDepreciationController */
/* @var $model AssetDepreciation */
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
		<?php echo $form->label($model,'transaction_number'); ?>
		<?php echo $form->textField($model,'transaction_number',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'transaction_date'); ?>
		<?php echo $form->textField($model,'transaction_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'transaction_time'); ?>
		<?php echo $form->textField($model,'transaction_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'amount'); ?>
		<?php echo $form->textField($model,'amount',array('size'=>18,'maxlength'=>18)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'number_of_month'); ?>
		<?php echo $form->textField($model,'number_of_month'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'asset_purchase_id'); ?>
		<?php echo $form->textField($model,'asset_purchase_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->