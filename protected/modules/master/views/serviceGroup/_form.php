<?php
/* @var $this ServiceGroupController */
/* @var $serviceGroup->header ServiceGroup */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'service-group-form',
        'enableAjaxValidation' => false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($serviceGroup->header); ?>

    <div class="row">
        <?php echo $form->labelEx($serviceGroup->header, 'name'); ?>
        <?php echo $form->textField($serviceGroup->header, 'name', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($serviceGroup->header, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($serviceGroup->header, 'standard_flat_rate'); ?>
        <?php echo $form->textField($serviceGroup->header, 'standard_flat_rate', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($serviceGroup->header, 'standard_flat_rate'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($serviceGroup->header, 'description'); ?>
        <?php echo $form->textArea($serviceGroup->header, 'description', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($serviceGroup->header, 'description'); ?>
    </div>

    <hr />

    <div class="row buttons">
        <?php echo CHtml::submitButton($serviceGroup->header->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
