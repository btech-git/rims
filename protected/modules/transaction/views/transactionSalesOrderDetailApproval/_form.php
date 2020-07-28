<?php
/* @var $this TransactionSalesOrderDetailApprovalController */
/* @var $model TransactionSalesOrderDetailApproval */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'transaction-sales-order-detail-approval-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'sales_order_detail_id'); ?>
		<?php echo $form->textField($model,'sales_order_detail_id'); ?>
		<?php echo $form->error($model,'sales_order_detail_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'revision'); ?>
		<?php echo $form->textField($model,'revision'); ?>
		<?php echo $form->error($model,'revision'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'approval_type'); ?>
		<?php echo $form->textField($model,'approval_type',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'approval_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'supervisor_id'); ?>
		<?php echo $form->textField($model,'supervisor_id'); ?>
		<?php echo $form->error($model,'supervisor_id'); ?>
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