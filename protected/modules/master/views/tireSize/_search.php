<?php
/* @var $this TireSizeController */
/* @var $model TireSize */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <div class="row">
        <?php echo $form->label($model, 'id'); ?>
        <?php echo $form->textField($model, 'id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'section_width'); ?>
        <?php echo $form->textField($model, 'section_width', array('size' => 20, 'maxlength' => 20)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'aspect_ratio'); ?>
        <?php echo $form->textField($model, 'aspect_ratio', array('size' => 20, 'maxlength' => 20)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'construction_type'); ?>
        <?php echo $form->textField($model, 'construction_type', array('size' => 20, 'maxlength' => 20)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'rim_diameter'); ?>
        <?php echo $form->textField($model, 'rim_diameter', array('size' => 20, 'maxlength' => 20)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'load_rating'); ?>
        <?php echo $form->textField($model, 'load_rating', array('size' => 20, 'maxlength' => 20)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'speed_rating'); ?>
        <?php echo $form->textField($model, 'speed_rating', array('size' => 20, 'maxlength' => 20)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->