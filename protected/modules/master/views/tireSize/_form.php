<?php
/* @var $this TireSizeController */
/* @var $model TireSize */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'tire-size-form',
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
        <?php echo $form->labelEx($model, 'section_width'); ?>
        <?php echo $form->textField($model, 'section_width', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'section_width'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'aspect_ratio'); ?>
        <?php echo $form->textField($model, 'aspect_ratio', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'aspect_ratio'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'construction_type'); ?>
        <?php echo $form->textField($model, 'construction_type', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'construction_type'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'rim_diameter'); ?>
        <?php echo $form->textField($model, 'rim_diameter', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'rim_diameter'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'load_rating'); ?>
        <?php echo $form->textField($model, 'load_rating', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'load_rating'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'speed_rating'); ?>
        <?php echo $form->textField($model, 'speed_rating', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'speed_rating'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->