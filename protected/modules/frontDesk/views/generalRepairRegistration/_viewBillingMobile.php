<fieldset>
    <legend>Billing Estimation</legend>
    <div class="row">
        <div class="large-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Service Discount</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo number_format($model->discount_service, 2); ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Total Service</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->total_service; ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Discount Product</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo number_format($model->discount_product, 2); ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Total Product</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->total_product; ?>"> 
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Total Service Price</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo number_format($model->total_service_price, 2); ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Total Product Price</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo number_format($model->total_product_price, 2); ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">PPN Price</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo number_format($model->ppn_price, 2); ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">PPH Price</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo number_format($model->pph_price, 2); ?>"> 
                        </div>
                    </div>
                </div>
            
                <hr style="border:solid 2px; margin-top:0px; color:black">
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Grand Total</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo number_format($model->grand_total, 2); ?>"> 
                        </div>
                    </div>
                </div>
        </div>
    </div>
</fieldset>

<hr />
<fieldset>
    <legend>Downpayment</legend>
    <div class="row">
            <div class="large-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">DP #</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->downpayment_transaction_number; ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Tanggal</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->downpayment_transaction_date; ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Note</span>
                        </div>
                        <div class="small-8 columns">
                            <textarea name="" id="" cols="30" rows="5" readonly="true"><?php echo $model->downpayment_note; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Jumlah</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo number_format($model->downpayment_amount, 2); ?>"> 
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Status</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->downpayment_status; ?>">
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Created By</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo CHtml::encode(CHtml::value($model, 'userIdCreatedDownpayment.username')); ?>"> 
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Created Date</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->downpayment_created_datetime; ?>">
                        </div>
                    </div>
                </div>
        </div>
    </div>
</fieldset>

<hr />

<fieldset>
    <legend>Payment In</legend>
    <?php $invoiceHeader = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $model->id)); ?>
    <?php if (!empty($invoiceHeader)): ?>
        <?php $paymentInDetails = PaymentInDetail::model()->findAllByAttributes(array('invoice_header_id' => $invoiceHeader->id)); ?>
        <div class="row">
            <div class="large-6 columns">
                <table>
                    <thead>
                        <tr>
                            <th>Payment #</th>
                            <th>Tanggal</th>
                            <th>Type</th>
                            <th>Note</th>
                            <th>Memo</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($paymentInDetails as $paymentInDetail): ?>
                            <tr>
                                <td>
                                    <?php echo CHtml::link(CHtml::value($paymentInDetail, 'paymentIn.payment_number'), array(
                                        '/transaction/paymentIn/show',
                                        'id' => $paymentInDetail->payment_in_id, 
                                    ), array('target' => '_blank')); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", strtotime(CHtml::value($paymentInDetail, 'paymentIn.payment_date')))); ?>
                                </td>
                                <td><?php echo CHtml::encode(CHtml::value($paymentInDetail, 'paymentIn.paymentType.name')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($paymentInDetail, 'paymentIn.note')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($paymentInDetail, 'memo')); ?></td>
                                <td style="text-align: right"><?php echo CHtml::encode(number_format(CHtml::value($paymentInDetail, 'totalAmount'), 2)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="large-12 columns">
                <h3>No Payments Available</h3>
            </div>
        </div>
    <?php endif; ?>
</fieldset>