<?php
/* @var $this AssetCategoryController */
/* @var $model AssetCategory */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'asset-category-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'code'); ?>
        <?php echo $form->textField($model,'code',array('size'=>45,'maxlength'=>45)); ?>
        <?php echo $form->error($model,'code'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textField($model,'description',array('size'=>45,'maxlength'=>45)); ?>
        <?php echo $form->error($model,'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'type'); ?>
        <?php echo $form->textField($model,'type',array('size'=>45,'maxlength'=>45)); ?>
        <?php echo $form->error($model,'type'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'number_of_years'); ?>
        <?php echo $form->textField($model,'number_of_years',array('size'=>45,'maxlength'=>45)); ?>
        <?php echo $form->error($model,'number_of_years'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'coa_inventory_id'); ?>
        <?php echo $form->dropDownlist($model, 'coa_inventory_id', CHtml::listData(Coa::model()->findAllByAttributes(array('coa_sub_category_id' => 12, 'is_approved' => 1)),'id','name'), array('empty' => '-- Pilih COA --')); ?>
        <?php echo $form->error($model,'coa_inventory_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'coa_expense_id'); ?>
        <?php echo $form->dropDownlist($model, 'coa_expense_id', CHtml::listData(Coa::model()->findAllByAttributes(array('coa_sub_category_id' => 46, 'is_approved' => 1)),'id','name'), array('empty' => '-- Pilih COA --')); ?>
        <?php echo $form->error($model,'coa_expense_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'coa_accumulation_id'); ?>
        <?php echo $form->dropDownlist($model, 'coa_accumulation_id', CHtml::listData(Coa::model()->findAllByAttributes(array('coa_sub_category_id' => 13, 'is_approved' => 1)),'id','name'), array('empty' => '-- Pilih COA --')); ?>
        <?php echo $form->error($model,'coa_accumulation_id'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->