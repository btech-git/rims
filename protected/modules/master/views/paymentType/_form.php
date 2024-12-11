<?php
/* @var $this PaymentTypeController */
/* @var $model PaymentType */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'payment-type-form',
    'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
            <?php echo $form->labelEx($model,'name'); ?>
            <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>60)); ?>
            <?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
            <?php echo $form->labelEx($model, 'Biaya Potongan Bank'); ?>
            <?php echo $form->textField($model,'bank_fee_amount',array('size'=>60,'maxlength'=>60)); ?>
            <?php echo $form->error($model,'bank_fee_amount'); ?>
	</div>

	<div class="row">
            <?php echo $form->labelEx($model,'Jenis Potongan Bank'); ?>
            <?php echo $form->dropDownList($model, 'bank_fee_type', array(
                1 => '%',
                2 => 'Rp',
             ),array(
                'prompt' => '[--Pilih Jenis Biaya--]',
            )); ?>
            <?php echo $form->error($model,'bank_fee_type'); ?>
	</div>

	<div class="row">
            <?php echo $form->labelEx($model,'coa_id'); ?>
            <?php echo $form->dropDownList($model, 'coa_id', CHtml::listData(Coa::model()->findAllByAttributes(array('coa_sub_category_id' => 2)), 'id', 'name'),array(
                'prompt' => '[--Select COA--]',
            )); ?>
            <?php echo $form->error($model,'coa_id'); ?>
	</div>

	<div class="row">
            <?php echo $form->labelEx($model,'memo'); ?>
            <?php echo $form->textField($model,'memo',array('size'=>60,'maxlength'=>100)); ?>
            <?php echo $form->error($model,'memo'); ?>
	</div>

	<div class="row buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->