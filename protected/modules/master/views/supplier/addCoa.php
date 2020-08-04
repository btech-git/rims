<?php
/* @var $this CoaController */
/* @var $model Coa */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php echo CHtml::beginForm(); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('COA Category', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($coaReceivable, 'coaSubCategory.name')); ?>
                    </div>
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('COA Name', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextField($coaReceivable, 'name', array('size' => 50, 'maxlength' => 50)); ?>
                        <?php echo CHtml::error($coaReceivable, 'name'); ?>
                    </div>
                </div>
            </div>		

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('COA Category', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($coaOutstanding, 'coaSubCategory.name')); ?>
                    </div>
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('COA Name', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextField($coaOutstanding, 'name', array('size' => 50, 'maxlength' => 50)); ?>
                        <?php echo CHtml::error($coaOutstanding, 'name'); ?>
                    </div>
                </div>
            </div>		

            <div class="field buttons text-center">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton')); ?>
            </div>
        </div>
    </div>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->