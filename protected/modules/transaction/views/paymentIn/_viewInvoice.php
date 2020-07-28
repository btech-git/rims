<div id="invoice-Detail">
    <fieldset>
        <legend>Invoice</legend>
        <div class="large-4 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Invoice Date</span>
                    </div>
                    <div class="small-8 columns">
                        <input type="text" readonly="true" id="Invoice_invoice_date" value="<?php echo $model->invoice_id != "" ? $model->invoice->invoice_date : '' ?>" > 
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Due Date </span>
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
                        <span class="prefix">Reference Type</span>
                    </div>
                    <div class="small-8 columns">
                        <input type="text" readonly="true" id="Invoice_reference_type" value="<?php echo $model->invoice_id != "" ? $model->invoice->reference_type : '' ?>"> 
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Reference Number</span>
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
                        <input type="text" readonly="true" id="Invoice_total_price" value="<?php echo $model->invoice_id != "" ? $model->invoice->total_price : '0,00' ?>"> 
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Payment Amount</span>
                    </div>
                    <div class="small-8 columns">
                        <input type="text" readonly="true" id="Invoice_payment_amount" value="<?php echo $model->invoice_id != "" ? $model->invoice->payment_amount : '0,00' ?>"> 
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Payment Left</span>
                    </div>
                    <div class="small-8 columns">
                        <input type="text" readonly="true" id="Invoice_payment_left" value="<?php echo $model->invoice_id != "" ? $model->invoice->payment_left : '0,00' ?>"> 
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</div>