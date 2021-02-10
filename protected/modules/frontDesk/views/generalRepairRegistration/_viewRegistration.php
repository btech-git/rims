<fieldset>
    <legend>Transaction</legend>
    <div class="row">
        <div class="large-12 columns">
            <div class="large-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Transaction #</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->transaction_number; ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Transaction Date</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->transaction_date; ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Repair Type</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->repair_type; ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Status</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->status; ?>"> 
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Service Status</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->service_status; ?>"> 
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Payment Status</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->payment_status; ?>"> 
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Vehicle Status</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->vehicle_status; ?>"> 
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Problem</span>
                        </div>
                        <div class="small-8 columns">
                            <textarea name="" id="" cols="30" rows="5" readonly="true"><?php echo $model->problem; ?></textarea>
                        </div>
                    </div>
                </div>

                <?php if ($model->is_insurance == 1): ?>
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <span class="prefix">Insurance Company</span>
                            </div>
                            <div class="small-8 columns">
                                <input type="text" readonly="true" value="<?php echo $model->insuranceCompany->name; ?>"> 
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div> <!-- end div large -->

            <div class="large-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Sales Order #</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->sales_order_number; ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Sales Order Date</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->sales_order_date; ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Work Order #</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->work_order_number; ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Work Order date</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->work_order_date; ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Invoice #</span>
                        </div>
                        <div class="small-8 columns">
                            <?php
                            $invoiceCriteria = new CDbCriteria;
                            $invoiceCriteria->addCondition("status != 'CANCELLED'");
                            $invoiceCriteria->addCondition("registration_transaction_id = " . $model->id);
                            ?>
                            <?php $invoice = InvoiceHeader::model()->find($invoiceCriteria) ?>
                            <input type="text" readonly="true" value="<?php echo count($invoice) > 0 ? $invoice->invoice_number : ''; ?>"> 
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">User ID</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->user != null ? $model->user->username : ''; ?>"> 
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Branch</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->branch != null ? $model->branch->name : ''; ?>">
                        </div>
                    </div>
                </div>
            </div><!-- end div large -->
        </div>
    </div>
</fieldset>