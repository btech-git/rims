<div class="clearfix page-action">
    <div class="form">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'registration-transaction-form',
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
            'enableAjaxValidation'=>false,
        )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($invoice->header); ?>
        <?php echo $form->errorSummary($invoice->details); ?>
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>

        <div class="row">
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($invoice->header, 'invoice_date', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $invoice->header,
                                'attribute' => "invoice_date",
                                'options' => array(
                                    'minDate' => '-7W',
                                    'maxDate' => '+6M',
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ),
                                'htmlOptions' => array(
//                                    'value'=>date('Y-m-d'),
                                    'readonly' => true,
                                ),
                            )); ?>
                            <?php echo $form->error($invoice->header, 'invoice_date'); ?>
                        </div>
                    </div>
                </div>		

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($invoice->header, 'branch_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($invoice->header, 'branch.name')); ?>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($invoice->header, 'vehicle_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($invoice->header, 'vehicle.plate_number')); ?>
                        </div>
                    </div>
                </div>
                
                <?php if (!empty($invoice->header->id)): ?>
                    <div class="field">
                        <div class="row collapse">
                            <div class="medium-4 columns">
                                <?php echo $form->labelEx($invoice->header, 'transaction_tax_number', array('class' => 'prefix')); ?>
                            </div>
                            <div class="medium-8 columns">
                                <?php echo $form->textField($invoice->header, 'transaction_tax_number'); ?>
                                <?php echo $form->error($invoice->header, 'transaction_tax_number'); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($invoice->header, 'registration_transaction_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($invoice->header, 'registrationTransaction.transaction_number')); ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($invoice->header, 'customer_id', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($invoice->header, 'customer.name')); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            
                            <?php echo $form->labelEx($invoice->header, 'Jatuh Tempo (hari)', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::encode(CHtml::value($invoice->header, 'customer.tenor')); ?>
                        </div>
                    </div>
                </div>
                
                <?php if (!empty($invoice->header->id)): ?>
                    <div class="field">
                        <div class="row collapse">
                            <div class="medium-4 columns">
                                <?php echo $form->labelEx($invoice->header, 'coretax_receipt_number', array('class' => 'prefix')); ?>
                            </div>
                            <div class="medium-8 columns">
                                <?php echo $form->textField($invoice->header, 'coretax_receipt_number'); ?>
                                <?php echo $form->error($invoice->header, 'coretax_receipt_number'); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="row">
            <div class="small-12 medium-12 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="medium-2 columns">
                            <?php echo $form->labelEx($invoice->header, 'note', array('class' => 'prefix')); ?>
                        </div>
                        <div class="medium-10 columns">
                            <?php echo $form->textArea($invoice->header, 'note', array('rows' => 3, 'cols' => 50)); ?>
                            <?php echo $form->error($invoice->header, 'note'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="large-12 columns">
                <fieldset>
                    <legend>Details</legend>

                    <div class="row">
                        <div class="large-12 columns">
                            <div class="detail" id="detail">
                                <?php $this->renderPartial('_detail', array('invoice' => $invoice)); ?>
                            </div>
                        </div>	
                    </div>
                </fieldset>
            </div>
        </div>

        <div class="row">
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($invoice->header, 'Paket', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo number_format(CHtml::encode(CHtml::value($invoice->header, 'package_price')), 2); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($invoice->header, 'service_price', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo number_format(CHtml::encode(CHtml::value($invoice->header, 'service_price')), 2); ?>
                        </div>
                    </div>
                </div>		

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($invoice->header, 'product_price', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo number_format(CHtml::encode(CHtml::value($invoice->header, 'product_price')), 2); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($invoice->header, 'Ppn Coretax', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($invoice->header, 'tax_amount_coretax', array(
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'dataType' => 'JSON',
                                    'url' => CController::createUrl('ajaxJsonTaxAmount', array('id' => $invoice->header->id)),
                                    'success' => 'function(data) {
                                        $("#tax_amount_coretax").html(data.taxAmountCoretax);
                                    }',
                                )),
                            )); ?>
                            <div id="tax_amount_coretax" style="text-align: right;">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($invoice->header, 'tax_amount_coretax'))); ?>
                            </div>
                            <?php echo $form->error($invoice->header, 'tax_amount_coretax'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="" class="prefix">Sub Total</label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo number_format(CHtml::encode(CHtml::value($invoice->header, 'subTotal')), 2); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="" class="prefix">PPN <?php echo CHtml::encode(CHtml::value($invoice->header, 'tax_percentage')); ?>%</label>
                        </div>
                        <div class="small-8 columns">
                            <?php echo number_format(CHtml::encode(CHtml::value($invoice->header, 'ppn_total')), 2); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($invoice->header, 'total_price', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo number_format(CHtml::encode(CHtml::value($invoice->header, 'total_price')), 2); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($invoice->header, 'DPP Coretax', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($invoice->header, 'grand_total_coretax', array(
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'dataType' => 'JSON',
                                    'url' => CController::createUrl('ajaxJsonTaxAmount', array('id' => $invoice->header->id)),
                                    'success' => 'function(data) {
                                        $("#grand_total_coretax").html(data.grandTotalCoretax);
                                    }',
                                )),
                            )); ?>
                            <div id="grand_total_coretax" style="text-align: right;">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($invoice->header, 'grand_total_coretax'))); ?>
                            </div>
                            <?php echo $form->error($invoice->header, 'grand_total_coretax'); ?>
                        </div>
                    </div>
                </div>

                <div class="field buttons text-center">
                    <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                    <?php echo CHtml::submitButton($invoice->header->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'confirm' => 'Are you sure you want to save?')); ?>
                </div>
                <?php echo IdempotentManager::generate(); ?>

            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div><!-- form -->

<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('myjavascript', '
		$(".numbers").number( true,2, ".", ",");
    ', CClientScript::POS_END);
?>