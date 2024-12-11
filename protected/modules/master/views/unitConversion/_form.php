<?php
/* @var $this UnitConversionController */
/* @var $model UnitConversion */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
    <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/unitConversion/admin'; ?>"><span class="fa fa-th-list"></span>Manage Unit Conversions</a>
    <h1><?php if ($model->isNewRecord) {
    echo "New Unit Conversion";
} else {
    echo "Update Unit Conversion";
} ?></h1>
    <hr />
    <!-- begin FORM -->
    <div class="form">

        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'unit-conversion-form',
            'enableAjaxValidation' => false,
        )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($model); ?>

        <div class="row">
            <div class="small-12 medium-6 columns">         
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'unit_from_id'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeDropDownList($model, 'unit_from_id', CHtml::listData(Unit::model()->findAll(), 'id', 'name'), array(
                                'empty' => '-- Select Satuan Awal --'
                            )); ?>
                            <?php echo $form->error($model, 'unit_from_id'); ?>
                        </div>
                    </div>
                </div>		 
            </div>		
        </div>

        <div class="row">
            <div class="small-12 medium-6 columns">         
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'unit_to_id'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeDropDownList($model, 'unit_to_id', CHtml::listData(Unit::model()->findAll(), 'id', 'name'), array(
                                'empty' => '-- Select Satuan Konversi --'
                            )); ?>
                            <?php echo $form->error($model, 'unit_to_id'); ?>
                        </div>
                    </div>
                </div>		 
            </div>		
        </div>

        <div class="row">
            <div class="small-12 medium-6 columns">         
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label class="prefix"><?php echo $form->labelEx($model, 'multiplier'); ?></label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($model, 'multiplier'); ?>
                            <?php echo $form->error($model, 'multiplier'); ?>
                        </div>
                    </div>
                </div>		 
            </div>		
        </div>
        
        <hr />
        
        <div class="field buttons text-center">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>