<?php

$this->breadcrumbs=array(
	'Invoice Headers'=>array('admin'),
	$invoice->id=>array('view','id'=>$invoice->id),
	'Update',
);
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <h1>Update Faktur Pajak Invoice</h1>
        <div class="form">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'registration-transaction-form',
                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                'enableAjaxValidation'=>false,
            )); ?>

            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <div class="row">
                <div class="small-12 medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($invoice, 'invoice_date', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::encode(CHtml::value($invoice, 'invoice_date')); ?>
                            </div>
                        </div>
                    </div>		

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($invoice, 'branch_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::encode(CHtml::value($invoice, 'branch.name')); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($invoice, 'vehicle_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::encode(CHtml::value($invoice, 'vehicle.plate_number')); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="row collapse">
                            <div class="medium-4 columns">
                                <?php echo $form->labelEx($invoice, 'transaction_tax_number', array('class' => 'prefix')); ?>
                            </div>
                            <div class="medium-8 columns">
                                <?php echo $form->textField($invoice, 'transaction_tax_number'); ?>
                                <?php echo $form->error($invoice, 'transaction_tax_number'); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="row collapse">
                            <div class="medium-4 columns">
                                <?php echo $form->labelEx($invoice, 'coretax_receipt_number', array('class' => 'prefix')); ?>
                            </div>
                            <div class="medium-8 columns">
                                <?php echo $form->textField($invoice, 'coretax_receipt_number'); ?>
                                <?php echo $form->error($invoice, 'coretax_receipt_number'); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="small-12 medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($invoice, 'registration_transaction_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::encode(CHtml::value($invoice, 'registrationTransaction.transaction_number')); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($invoice, 'customer_id', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::encode(CHtml::value($invoice, 'customer.name')); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">

                                <?php echo $form->labelEx($invoice, 'Jatuh Tempo (hari)', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo CHtml::encode(CHtml::value($invoice, 'customer.tenor')); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="row collapse">
                            <div class="medium-4 columns">
                                <?php echo $form->labelEx($invoice, 'note', array('class' => 'prefix')); ?>
                            </div>
                            <div class="medium-8 columns">
                                <?php echo $form->textArea($invoice, 'note', array('rows' => 3, 'cols' => 50)); ?>
                                <?php echo $form->error($invoice, 'note'); ?>
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
                                    <?php if (count($invoice->invoiceDetails) > 0): ?>
                                        <table>
                                            <thead>
                                                <th>Product / Service / Paket</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Price</th>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($invoice->invoiceDetails as $i => $detail): ?>
                                                    <tr>
                                                        <?php if ($detail->product_id != ""): ?>
                                                            <td><?php echo $detail->product->name; ?></td>
                                                        <?php elseif ($detail->service_id != ""): ?>
                                                            <td><?php echo $detail->service->name; ?></td>
                                                        <?php elseif ($detail->sale_package_header_id != ""): ?>
                                                            <td><?php echo $detail->salePackageHeader->name; ?></td>
                                                        <?php endif; ?>
                                                        <td style="text-align: center"><?php echo number_format($detail->quantity, 0); ?></td>
                                                        <td style="text-align: right">
                                                            <span class="numbers"><?php echo number_format($detail->unit_price, 2); ?></span>
                                                        </td>
                                                        <td style="text-align: right">
                                                            <span class="numbers"><?php echo number_format($detail->total_price, 2); ?></span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    <?php endif; ?>
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
                                <?php echo $form->labelEx($invoice, 'Paket', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo number_format(CHtml::encode(CHtml::value($invoice, 'package_price')), 2); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($invoice, 'service_price', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo number_format(CHtml::encode(CHtml::value($invoice, 'service_price')), 2); ?>
                            </div>
                        </div>
                    </div>		

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($invoice, 'product_price', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo number_format(CHtml::encode(CHtml::value($invoice, 'product_price')), 2); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($invoice, 'PPn Coretax', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($invoice, 'tax_amount_coretax', array(
                                    'onchange' => CHtml::ajax(array(
                                        'type' => 'POST',
                                        'dataType' => 'JSON',
                                        'url' => CController::createUrl('ajaxJsonTaxAmount', array('id' => $invoice->id)),
                                        'success' => 'function(data) {
                                            $("#tax_amount_coretax").html(data.taxAmountCoretax);
                                        }',
                                    )),
                                )); ?>
                                <div id="tax_amount_coretax" style="text-align: right;">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($invoice, 'tax_amount_coretax'))); ?>
                                </div>
                                <?php echo $form->error($invoice, 'tax_amount_coretax'); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="field buttons text-center">
                        <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                        <?php echo CHtml::submitButton($invoice->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'confirm' => 'Are you sure you want to save?')); ?>
                    </div>
                </div>

                <div class="small-12 medium-6 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label for="" class="prefix">Sub Total</label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo number_format(CHtml::encode(CHtml::value($invoice, 'subTotal')), 2); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label for="" class="prefix">PPN <?php echo CHtml::encode(CHtml::value($invoice, 'tax_percentage')); ?>%</label>
                            </div>
                            <div class="small-8 columns">
                                <?php echo number_format(CHtml::encode(CHtml::value($invoice, 'ppn_total')), 2); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($invoice, 'total_price', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo number_format(CHtml::encode(CHtml::value($invoice, 'total_price')), 2); ?>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <?php echo $form->labelEx($invoice, 'DPP Coretax', array('class' => 'prefix')); ?>
                            </div>
                            <div class="small-8 columns">
                                <?php echo $form->textField($invoice, 'grand_total_coretax', array(
                                    'onchange' => CHtml::ajax(array(
                                        'type' => 'POST',
                                        'dataType' => 'JSON',
                                        'url' => CController::createUrl('ajaxJsonTaxAmount', array('id' => $invoice->id)),
                                        'success' => 'function(data) {
                                            $("#grand_total_coretax").html(data.grandTotalCoretax);
                                        }',
                                    )),
                                )); ?>
                                <div id="grand_total_coretax" style="text-align: right;">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($invoice, 'grand_total_coretax'))); ?>
                                </div>
                                <?php echo $form->error($invoice, 'grand_total_coretax'); ?>
                            </div>
                        </div>
                    </div>
                    
                    <?php echo IdempotentManager::generate(); ?>

                </div>
            </div>

            <?php $this->endWidget(); ?>
        </div><!-- form -->
    </div><!-- form -->
</div>