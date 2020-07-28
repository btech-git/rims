<?php
/* @var $this MovementInDetailController */
/* @var $model MovementInDetail */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'movement-in-detail-form',
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
				<?php echo $form->labelEx($model,'receive_item_detail_id'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'receive_item_detail_id'); ?>
				<?php echo $form->error($model,'receive_item_detail_id'); ?>
			</div>
		</div>
	</div>		

	<div class="field">
		<div class="row collapse">
			<div class="small-4 columns">
				<?php echo $form->labelEx($model,'movement_in_header_id'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'movement_in_header_id'); ?>
				<?php echo $form->error($model,'movement_in_header_id'); ?>
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
				<?php echo $form->labelEx($model,'quantity_transaction'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'quantity_transaction'); ?>
				<?php echo $form->error($model,'quantity_transaction'); ?>
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
				<?php echo $form->labelEx($model,'warehouse_id'); ?>
			</div>
			<div class="small-8 columns">
				<?php echo $form->textField($model,'warehouse_id'); ?>
				<?php echo $form->error($model,'warehouse_id'); ?>
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