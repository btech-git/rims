<div class="clearfix page-action">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'product-pricing-request-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        ),
    )); ?>

    <hr />
    
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($productPricingRequest->header); ?>

    <div class="row">
        <div class="medium-12 columns">
            <div class="row">
                <div class="medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($productPricingRequest->header, 'Permintaan #'); ?></label>
                            </div>

                            <div class="small-8 columns"><?php echo CHtml::encode(CHtml::value($productPricingRequest->header, 'transaction_number')); ?></div>
                        </div>
                    </div>
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($productPricingRequest->header, 'Tanggal Request'); ?></label>
                            </div>

                            <div class="small-8 columns"><?php echo CHtml::encode(CHtml::value($productPricingRequest->header, 'request_date')); ?></div>
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($productPricingRequest->header, 'User Request'); ?></label>
                            </div>

                            <div class="small-8 columns"><?php echo CHtml::encode(CHtml::value($productPricingRequest->header, 'userIdRequest.username')); ?></div>
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($productPricingRequest->header, 'Catatan Request'); ?></label>
                            </div>

                            <div class="small-8 columns"><?php echo CHtml::encode(CHtml::value($productPricingRequest->header, 'request_note')); ?></div>
                        </div>
                    </div>
                    
                </div>
                
                <div class="medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix">Vehicle</label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::encode(CHtml::value($productPricingRequest->header, 'vehicleCarMake.name')); ?> -
                                <?php echo CHtml::encode(CHtml::value($productPricingRequest->header, 'vehicleCarModel.name')); ?> -
                                <?php echo CHtml::encode(CHtml::value($productPricingRequest->header, 'vehicleCarSubModel.name')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($productPricingRequest->header, 'Tahun Produksi'); ?></label>
                            </div>

                            <div class="small-8 columns"><?php echo CHtml::encode(CHtml::value($productPricingRequest->header, 'production_year')); ?></div>
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($productPricingRequest->header, 'Tanggal Reply'); ?></label>
                            </div>

                            <div class="small-8 columns"><?php echo CHtml::encode(CHtml::value($productPricingRequest->header, 'reply_date')); ?></div>
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($productPricingRequest->header, 'User Reply'); ?></label>
                            </div>

                            <div class="small-8 columns"><?php echo CHtml::encode(CHtml::value($productPricingRequest->header, 'userIdReply.username')); ?></div>
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label class="prefix"><?php echo $form->labelEx($productPricingRequest->header, 'Catatan Reply'); ?></label>
                            </div>

                            <div class="small-8 columns"><?php echo CHtml::activeTextArea($productPricingRequest->header, 'reply_note'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr />

    <div id="detail_div">
        <?php $this->renderPartial('_detailReply', array(
            'productPricingRequest' => $productPricingRequest,
        )); ?>
    </div>

    <hr />

    <div class="field buttons text-center">
        <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>

<?php echo IdempotentManager::generate(); ?>

<?php $this->endWidget(); ?>
</div><!-- form -->

<hr />

<div style="text-align: center">
    <h2>Uploaded Image</h2>
    <?php echo CHtml::image(Yii::app()->baseUrl . '/images/uploads/product_pricing_request/' . $productPricingRequest->header->id . '.' . $productPricingRequest->header->extension, "image", array("width" => "30%")); ?>  
</div>