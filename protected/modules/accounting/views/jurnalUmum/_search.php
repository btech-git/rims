<?php
/* @var $this JurnalUmumController */
/* @var $model JurnalUmum */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'kode_transaksi'); ?>
		<?php echo $form->textField($model,'kode_transaksi',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tanggal_transaksi'); ?>
		<?php echo $form->textField($model,'tanggal_transaksi'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'coa_id'); ?>
		<?php echo $form->textField($model,'coa_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'branch_id'); ?>
		<?php echo $form->textField($model,'branch_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'total'); ?>
		<?php echo $form->textField($model,'total',array('size'=>18,'maxlength'=>18)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'debet_kredit'); ?>
		<?php echo $form->textField($model,'debet_kredit',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tanggal_posting'); ?>
		<?php echo $form->textField($model,'tanggal_posting'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->