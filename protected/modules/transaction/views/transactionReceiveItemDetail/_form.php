<?php
/* @var $this TransactionReceiveItemDetailController */
/* @var $model TransactionReceiveItemDetail */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transaction-receive-item-detail-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'receive_item_id'); ?>
		<?php echo $form->textField($model,'receive_item_id'); ?>
		<?php echo $form->error($model,'receive_item_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'product_id'); ?>
		<?php echo $form->textField($model,'product_id'); ?>
		<?php echo $form->error($model,'product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qty_request'); ?>
		<?php echo $form->textField($model,'qty_request'); ?>
		<?php echo $form->error($model,'qty_request'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qty_good'); ?>
		<?php echo $form->textField($model,'qty_good'); ?>
		<?php echo $form->error($model,'qty_good'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qty_reject'); ?>
		<?php echo $form->textField($model,'qty_reject'); ?>
		<?php echo $form->error($model,'qty_reject'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qty_more'); ?>
		<?php echo $form->textField($model,'qty_more'); ?>
		<?php echo $form->error($model,'qty_more'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'qty_request_left'); ?>
		<?php echo $form->textField($model,'qty_request_left'); ?>
		<?php echo $form->error($model,'qty_request_left'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'barcode_product'); ?>
		<?php echo $form->textField($model,'barcode_product',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'barcode_product'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->