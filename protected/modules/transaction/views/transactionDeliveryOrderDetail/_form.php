<?php
/* @var $this TransactionDeliveryOrderDetailController */
/* @var $model TransactionDeliveryOrderDetail */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transaction-delivery-order-detail-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'delivery_order_id'); ?>
		<?php echo $form->textField($model,'delivery_order_id'); ?>
		<?php echo $form->error($model,'delivery_order_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_id'); ?>
		<?php echo $form->textField($model,'product_id'); ?>
		<?php echo $form->error($model,'product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity_request'); ?>
		<?php echo $form->textField($model,'quantity_request'); ?>
		<?php echo $form->error($model,'quantity_request'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity_delivery'); ?>
		<?php echo $form->textField($model,'quantity_delivery'); ?>
		<?php echo $form->error($model,'quantity_delivery'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity_request_left'); ?>
		<?php echo $form->textField($model,'quantity_request_left'); ?>
		<?php echo $form->error($model,'quantity_request_left'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'barcode_product'); ?>
		<?php echo $form->textField($model,'barcode_product',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'barcode_product'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->