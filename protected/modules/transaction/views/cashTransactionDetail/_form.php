<?php
/* @var $this CashTransactionDetailController */
/* @var $model CashTransactionDetail */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cash-transaction-detail-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'cash_transaction_id'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'cash_transaction_id'); ?>
				<?php echo $form->error($model,'cash_transaction_id'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'coa_id'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'coa_id'); ?>
				<?php echo $form->error($model,'coa_id'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'amount'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'amount',array('size'=>18,'maxlength'=>18)); ?>
				<?php echo $form->error($model,'amount'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'notes'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
				<?php echo $form->error($model,'notes'); ?>
			</div>
		</div>
	</div>		

		<div class="field buttons text-center">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
		</div>
	</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->