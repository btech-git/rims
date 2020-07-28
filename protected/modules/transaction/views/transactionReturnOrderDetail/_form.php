<?php
/* @var $this TransactionReturnOrderDetailController */
/* @var $model TransactionReturnOrderDetail */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transaction-return-order-detail-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'return_order_id'); ?>
		<?php echo $form->textField($model,'return_order_id'); ?>
		<?php echo $form->error($model,'return_order_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_id'); ?>
		<?php echo $form->textField($model,'product_id'); ?>
		<?php echo $form->error($model,'product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qty_request_left'); ?>
		<?php echo $form->textField($model,'qty_request_left'); ?>
		<?php echo $form->error($model,'qty_request_left'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qty_reject'); ?>
		<?php echo $form->textField($model,'qty_reject'); ?>
		<?php echo $form->error($model,'qty_reject'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->