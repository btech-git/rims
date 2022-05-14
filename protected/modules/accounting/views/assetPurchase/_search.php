<?php
/* @var $this AssetPurchaseController */
/* @var $model AssetPurchase */
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
		<?php echo $form->label($model,'purchase_price'); ?>
		<?php echo $form->textField($model,'purchase_price',array('size'=>18,'maxlength'=>18)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'monthly_useful_life'); ?>
		<?php echo $form->textField($model,'monthly_useful_life'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'depreciation_amount'); ?>
		<?php echo $form->textField($model,'depreciation_amount',array('size'=>18,'maxlength'=>18)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'depreciation_start_date'); ?>
		<?php echo $form->textField($model,'depreciation_start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'depreciation_end_date'); ?>
		<?php echo $form->textField($model,'depreciation_end_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'asset_category_id'); ?>
		<?php echo $form->textField($model,'asset_category_id'); ?>
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