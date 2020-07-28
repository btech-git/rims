<?php
/* @var $this CashTransactionImagesController */
/* @var $model CashTransactionImages */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cash-transaction-images-form',
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
				<?php echo $form->labelEx($model,'extension'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'extension',array('size'=>5,'maxlength'=>5)); ?>
				<?php echo $form->error($model,'extension'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'is_inactive'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'is_inactive'); ?>
				<?php echo $form->error($model,'is_inactive'); ?>
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