<?php
/* @var $this JurnalUmumController */
/* @var $model JurnalUmum */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'jurnal-umum-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'kode_transaksi'); ?>
		<?php echo $form->textField($model,'kode_transaksi',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'kode_transaksi'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tanggal_transaksi'); ?>
		<?php echo $form->textField($model,'tanggal_transaksi'); ?>
		<?php echo $form->error($model,'tanggal_transaksi'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'coa_id'); ?>
		<?php echo $form->textField($model,'coa_id'); ?>
		<?php echo $form->error($model,'coa_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'branch_id'); ?>
		<?php echo $form->textField($model,'branch_id'); ?>
		<?php echo $form->error($model,'branch_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total'); ?>
		<?php echo $form->textField($model,'total',array('size'=>18,'maxlength'=>18)); ?>
		<?php echo $form->error($model,'total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'debet_kredit'); ?>
		<?php echo $form->textField($model,'debet_kredit',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'debet_kredit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tanggal_posting'); ?>
		<?php echo $form->textField($model,'tanggal_posting'); ?>
		<?php echo $form->error($model,'tanggal_posting'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->