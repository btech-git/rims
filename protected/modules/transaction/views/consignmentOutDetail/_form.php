<?php
/* @var $this ConsignmentOutDetailController */
/* @var $model ConsignmentOutDetail */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'consignment-out-detail-form',
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
				<?php echo $form->labelEx($model,'consignment_out_id'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'consignment_out_id'); ?>
				<?php echo $form->error($model,'consignment_out_id'); ?>
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
				<?php echo $form->labelEx($model,'qty_sent'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'qty_sent'); ?>
				<?php echo $form->error($model,'qty_sent'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'sale_price'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'sale_price',array('size'=>18,'maxlength'=>18)); ?>
				<?php echo $form->error($model,'sale_price'); ?>
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