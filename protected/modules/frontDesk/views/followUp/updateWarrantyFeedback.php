<?php $this->breadcrumbs = array(
    'Material Request'=>array('admin'),
    'Create',
); ?>

<h1>Customer Warranty</h1>

<div id="maincontent">
    <div class="clearfix page-action">
        <div class="form">
            <?php echo CHtml::beginForm(); ?>
            <div class="row">
                <div class="medium-12 columns">
                    <div class="large-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Invoice #</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $invoiceHeader->invoice_number; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Date</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $invoiceHeader->invoice_date; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Repair Type</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $invoiceHeader->registrationTransaction->repair_type; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Document Status</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $invoiceHeader->status; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Vehicle Status</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $invoiceHeader->vehicle->status_location; ?>"> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="large-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Work Order #</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $invoiceHeader->registrationTransaction->work_order_number; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Work Order date</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $invoiceHeader->registrationTransaction->work_order_date; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">User Admin</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $invoiceHeader->user != null ? $invoiceHeader->user->username : ''; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Assigned Mechanic</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo !empty($invoiceHeader->registrationTransaction->employee_id_assign_mechanic) ? $invoiceHeader->registrationTransaction->employeeIdAssignMechanic->name : ''; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Sales</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo !empty($invoiceHeader->registrationTransaction->employee_id_sales_person) ? $invoiceHeader->registrationTransaction->employeeIdSalesPerson->name : ''; ?>"> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr />
                
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Parts / Service</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Discount</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($invoiceHeader->invoiceDetails as $i => $detail): ?>
                                <tr>
                                    <td><?php echo empty($detail->product_id) ? $detail->service->name : $detail->product->name; ?></td>
                                    <td style="text-align: center"><?php echo number_format($detail->quantity,0); ?></td>
                                    <td style="text-align: right"><?php echo number_format($detail->unit_price,2); ?></td>
                                    <td style="text-align: right"><?php echo number_format($detail->discount,2); ?></td>
                                    <td style="text-align: right"><?php echo number_format($detail->total_price,2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="text-align: right" colspan="4">Sub Total</td>
                                <td style="text-align: right"><?php echo number_format($invoiceHeader->subTotal,2); ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right" colspan="4">Pph</td>
                                <td style="text-align: right"><?php echo number_format($invoiceHeader->pph_total,2); ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right" colspan="4">Ppn</td>
                                <td style="text-align: right"><?php echo number_format($invoiceHeader->ppn_total,2); ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right" colspan="4">Grand Total</td>
                                <td style="text-align: right"><?php echo number_format($invoiceHeader->total_price,2); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
                
            <div class="row">
                <div class="medium-12 columns">
                    <div class="large-12 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Feedback</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::activeTextArea($invoiceHeader, 'warranty_feedback', array('rows' => 5)); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <br /><br />

                <div class="row buttons">
                    <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                    <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
                </div>
                <?php echo IdempotentManager::generate(); ?>
                <?php echo CHtml::endForm(); ?>
            </div>
        </div>
    </div>
</div><!-- form -->