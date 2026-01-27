<?php
/* @var $this OilSaeController */
/* @var $model OilSae */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'oil-sae-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'winter_grade'); ?>
        <?php echo $form->textField($model, 'winter_grade', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'winter_grade'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'hot_grade'); ?>
        <?php echo $form->textField($model, 'hot_grade', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'hot_grade'); ?>
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->