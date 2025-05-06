<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'coa-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('onsubmit' => 'return false;'),
    )); ?>
    
    <hr />
    
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="small-12 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($model, 'opening_balance'); ?></label>  
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->hiddenField($model, 'id', array('size' => 60, 'maxlength' => 100)); ?>
                        <?php echo $form->textField($model, 'opening_balance', array('size' => 18, 'maxlength' => 18)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr />
    
    <div class="field buttons text-center">
        <?php if ($model->isNewRecord): ?>
            <?php echo CHtml::submitButton('Create', array(
                'class' => 'button cbutton',
                'id' => 'createbtn',
                'onclick' => 'if (window.confirm("Are you sure you want to save?"))' . CHtml::ajax(array(
                    'type' => 'POST',
                    'url' => CController::createUrl('ajaxHtmlSave'),
                    'update' => '#coa_div',
                )),
            )); ?>
        <?php else: ?>
            <?php echo CHtml::submitButton('Save', array(
                'class' => 'button cbutton',
                'onclick' => 'if (window.confirm("Are you sure you want to save?")) ' . CHtml::ajax(array(
                    'type' => 'POST',
                    'url' => CController::createUrl('ajaxHtmlSave'),
                    'update' => '#coa_div',
                )),
            )); ?>
        <?php endif; ?>
    </div>
    <?php $this->endWidget(); ?>
</div>