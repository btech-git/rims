<?php
/* @var $this TransactionReceiveItemController */
/* @var $model TransactionReceiveItem */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transaction-receive-item-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'receive_item_no'); ?>
		<?php echo $form->textField($model,'receive_item_no',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'receive_item_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'receive_item_date'); ?>
		<?php echo $form->textField($model,'receive_item_date'); ?>
		<?php echo $form->error($model,'receive_item_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'arrival_date'); ?>
		<?php echo $form->textField($model,'arrival_date'); ?>
		<?php echo $form->error($model,'arrival_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'recipient_id'); ?>
		<?php echo $form->textField($model,'recipient_id'); ?>
		<?php echo $form->error($model,'recipient_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'recipient_branch_id'); ?>
		<?php echo $form->textField($model,'recipient_branch_id'); ?>
		<?php echo $form->error($model,'recipient_branch_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'request_type'); ?>
		<?php echo $form->textField($model,'request_type',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'request_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'request_code'); ?>
		<?php echo $form->textField($model,'request_code',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'request_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'request_date'); ?>
		<?php echo $form->textField($model,'request_date'); ?>
		<?php echo $form->error($model,'request_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'estimate_arrival_date'); ?>
		<?php echo $form->textField($model,'estimate_arrival_date'); ?>
		<?php echo $form->error($model,'estimate_arrival_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'destination_branch'); ?>
		<?php echo $form->textField($model,'destination_branch'); ?>
		<?php echo $form->error($model,'destination_branch'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'supplier_id'); ?>
		<?php echo $form->textField($model,'supplier_id'); ?>
		<?php echo $form->error($model,'supplier_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->