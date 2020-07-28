<?php
/* @var $this InvoiceDetailController */
/* @var $model InvoiceDetail */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'invoice-detail-form',
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
				<?php echo $form->labelEx($model,'invoice_id'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'invoice_id'); ?>
				<?php echo $form->error($model,'invoice_id'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'service_id'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'service_id'); ?>
				<?php echo $form->error($model,'service_id'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'product_id'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'product_id'); ?>
				<?php echo $form->error($model,'product_id'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'quantity'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'quantity'); ?>
				<?php echo $form->error($model,'quantity'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'unit_price'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'unit_price',array('size'=>18,'maxlength'=>18)); ?>
				<?php echo $form->error($model,'unit_price'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'total_price'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'total_price',array('size'=>18,'maxlength'=>18)); ?>
				<?php echo $form->error($model,'total_price'); ?>
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