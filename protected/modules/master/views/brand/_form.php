<?php
/* @var $this BrandController */
/* @var $model Brand */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
    <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/brand/admin'; ?>"><span class="fa fa-th-list"></span>Manage Brand</a>
    <h1>
        <?php if ($model->isNewRecord) {
            echo "New Brand";
        } else {
            echo "Update Brand";
        } ?>
    </h1>
    <!-- begin FORM -->

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'brand-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    )); ?>

    <hr />
    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($model, 'name'); ?></label>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'name', array('size' => 30, 'maxlength' => 30)); ?>
                        <?php echo $form->error($model, 'name'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($model, 'status'); ?>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo $form->dropDownList($model, 'status', array(
                            'Active' => 'Active',
                            'Inactive' => 'Inactive',
                        )); ?>
                        <?php echo $form->error($model, 'status'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr />

    <div class="field buttons text-center">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'id' => 'SubmitButton')); ?>
    </div>

    <?php //echo CHtml::button('Test', array('id' => 'TestButton'));  ?>

    <?php echo CHtml::hiddenField(Idempotent::TOKEN_NAME, Idempotent::generateToken()); ?>

    <?php $this->endWidget(); ?>
</div><!-- form -->

<script>
//    var brandForm = document.getElementById('brand-form');
//    var submitButton = document.getElementById('SubmitButton');
//    var testButton = document.getElementById('TestButton');
//    testButton.addEventListener('click', function() {
//        //submitButton.click();
//        //submitButton.click();
//        brandForm.submit();
//        brandForm.submit();
//    }, false);
</script>