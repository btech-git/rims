<div class="clearfix page-action">
    <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . 'admin'; ?>"><span class="fa fa-th-list"></span>Manage Permintaan Harga</a>
    <h1>
        <?php if ($model->isNewRecord) {
            echo "New Permintaan Harga";
        } else {
            echo "Update Permintaan Harga";
        } ?>
    </h1>
    <!-- begin FORM -->

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'product-pricing-request-form',
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
                        <label class="prefix"><?php echo $form->labelEx($model, 'product_name'); ?></label>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($model, 'product_name')); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($model, 'request_date'); ?></label>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($model, 'request_date')); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($model, 'quantity'); ?></label>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($model, 'quantity')); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($model, 'user_id_request'); ?></label>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($model, 'userIdRequest.username')); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($model, 'request_note'); ?></label>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($model, 'request_note')); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($model, 'branch_id_request'); ?></label>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($model, 'branchIdRequest.code')); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($model, 'recommended_price'); ?></label>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextField($model, 'recommended_price'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($model, 'reply_note'); ?></label>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextArea($model, 'reply_note'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr />

    <div style="text-align: center">
        <h2>Uploaded Image</h2>
        <?php echo CHtml::image('//raperind.com/rimsfront/images/product_pricing_request/' . $model->id . '.' . $model->extension, "image", array("width" => "30%")); ?>  
    </div>
    <div class="field buttons text-center">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'id' => 'SubmitButton')); ?>
    </div>

    <?php echo IdempotentManager::generate(); ?>

    <?php $this->endWidget(); ?>
</div><!-- form -->
