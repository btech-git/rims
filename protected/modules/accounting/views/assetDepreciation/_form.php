<?php
/* @var $this AssetDepreciationController */
/* @var $model AssetDepreciation */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'asset-depreciation-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'asset_id'); ?>
                <?php echo $form->dropDownlist($model, 'asset_id', CHtml::listData(Asset::model()->findAll(),'id','name'), array('empty' => '-- Pilih Asset --')); ?>
		<?php echo $form->error($model,'asset_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'transaction_number'); ?>
		<?php echo $form->textField($model,'transaction_number',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'transaction_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'transaction_date'); ?>
		<?php echo $form->textField($model,'transaction_date'); ?>
		<?php echo $form->error($model,'transaction_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'transaction_time'); ?>
		<?php echo $form->textField($model,'transaction_time'); ?>
		<?php echo $form->error($model,'transaction_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'amount'); ?>
		<?php echo $form->textField($model,'amount',array('size'=>18,'maxlength'=>18)); ?>
		<?php echo $form->error($model,'amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'number_of_month'); ?>
		<?php echo $form->textField($model,'number_of_month'); ?>
		<?php echo $form->error($model,'number_of_month'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->