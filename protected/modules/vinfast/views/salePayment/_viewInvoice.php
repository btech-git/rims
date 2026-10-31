<div id="invoice-Detail">
    <fieldset>
        <legend>Invoice</legend>
        <div class="large-4 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Date</span>
                    </div>
                    <div class="small-8 columns">
                        <input type="text" readonly="true" id="Invoice_invoice_date" value="<?php echo $model->invoice_id != "" ? $model->invoice->invoice_date : '' ?>" > 
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Due Date</span>
                    </div>
                    <div class="small-8 columns">
                        <input type="text" readonly="true" id="Invoice_due_date" value="<?php echo $model->invoice_id != "" ? $model->invoice->due_date : '' ?>"> 
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Status</span>
                    </div>
                    <div class="small-8 columns">
                        <input type="text" readonly="true" id="Invoice_status" value="<?php echo $model->invoice_id != "" ? $model->invoice->status : '' ?>"> 
                    </div>
                </div>
            </div>
        </div>
        <div class="large-4 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Ref Type</span>
                    </div>
                    <div class="small-8 columns">
                        <input type="text" readonly="true" id="Invoice_reference_type" value="<?php echo $model->invoice_id != "" ? $model->invoice->referenceTypeLiteral : '' ?>"> 
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Sales Number</span>
                    </div>
                    <div class="small-8 columns">
                        <input type="text" readonly="true" id="Invoice_reference_number"> 
                    </div>
                </div>
            </div>

        </div>
        <div class="large-4 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Grand Total</span>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, 'invoice.total_price'))); ?>
                        <!--<input type="text" readonly="true" id="Invoice_total_price" value="<?php //echo $model->invoice_id != "" ? $model->invoice->total_price : '0,00' ?>">--> 
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Payment Amount</span>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, 'invoice.payment_amount'))); ?>
                        <!--<input type="text" readonly="true" id="Invoice_payment_amount" value="<?php // echo $model->invoice_id != "" ? $model->invoice->payment_amount : '0,00' ?>">--> 
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Remaining</span>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, 'invoice.payment_left'))); ?>
                        <!--<input type="text" readonly="true" id="Invoice_payment_left" value="<?php // echo $model->invoice_id != "" ? $model->invoice->payment_left : '0,00' ?>">--> 
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</div>

<div id="payment">
    <fieldset>
        <legend>Payment</legend>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Number</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($invoice->paymentIns as $paymentIn): ?>
                        <tr>
                            <td><?php echo CHtml::encode(CHtml::value($paymentIn, 'payment_number')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($paymentIn, 'payment_date')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($paymentIn, 'paymentType.name')); ?></td>
                            <td><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn, 'payment_amount'))); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($paymentIn, 'status')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($paymentIn, 'note')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
    </fieldset>
</div>
