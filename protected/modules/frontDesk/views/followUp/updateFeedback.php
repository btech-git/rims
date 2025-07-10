<?php $this->breadcrumbs = array(
    'Material Request'=>array('admin'),
    'Create',
); ?>

<h1>Feedback Customer</h1>

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
                                    <span class="prefix">Transaction #</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $registrationTransaction->transaction_number; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Transaction Date</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $registrationTransaction->transaction_date; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Repair Type</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $registrationTransaction->repair_type; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Document Status</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $registrationTransaction->status; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Service Status</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $registrationTransaction->service_status; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Payment Status</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $registrationTransaction->payment_status; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Vehicle Status</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $registrationTransaction->vehicle_status; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Problem</span>
                                </div>
                                <div class="small-8 columns">
                                    <textarea name="" id="" cols="30" rows="5" readonly="true"><?php echo $registrationTransaction->problem; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="large-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Sales Order #</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $registrationTransaction->sales_order_number; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Sales Order Date</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $registrationTransaction->sales_order_date; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Work Order #</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $registrationTransaction->work_order_number; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Work Order date</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $registrationTransaction->work_order_date; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Invoice #</span>
                                </div>
                                <div class="small-8 columns">
                                    <?php /*
                                    $invoiceCriteria = new CDbCriteria;
                                    $invoiceCriteria->addCondition("status != 'CANCELLED'");
                                    $invoiceCriteria->addCondition("registration_transaction_id = " . $registrationTransaction->id);*/
                                    ?>
                                    <?php $invoice = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $registrationTransaction->id)) ?>
                                    <input type="text" readonly="true" value="<?php echo CHtml::encode(CHtml::value($invoice, 'invoice_number')); ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">User Admin</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $registrationTransaction->user != null ? $registrationTransaction->user->username : ''; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Branch</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $registrationTransaction->branch != null ? $registrationTransaction->branch->name : ''; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Assigned Mechanic</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo !empty($registrationTransaction->employee_id_assign_mechanic) ? $registrationTransaction->employeeIdAssignMechanic->name : ''; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Sales</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo !empty($registrationTransaction->employee_id_sales_person) ? $registrationTransaction->employeeIdSalesPerson->name : ''; ?>"> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr />
                
                <div>
                    <?php if (count($services) > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Service name</th>
                                    <th>Claim</th>
                                    <th>Price</th>
                                    <th>Discount Type</th>
                                    <th>Discount Price</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($services as $i => $service): ?>
                                    <tr>
                                        <td><?php echo $service->service->name; ?></td>
                                        <td><?php echo $service->claim; ?></td>
                                        <td><?php echo number_format($service->price,2); ?></td>
                                        <td><?php echo $service->discount_type; ?></td>
                                        <td><?php echo $service->discount_type == 'Percent' ? $service->discount_price : number_format($service->discount_price,2);; ?></td>
                                        <td><?php echo number_format($service->total_price,2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
                
                <hr />

                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Product name</th>
                                <th>Quantity</th>
                                <th>Retail Price</th>
                                <th>Sale Price</th>
                                <th>Discount Type</th>
                                <th>Discount</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($products) > 0): ?>
                                <?php foreach ($products as $i => $product): ?>
                                    <tr>
                                        <td><?php echo $product->product->name; ?></td>
                                        <td><?php echo $product->quantity; ?></td>
                                        <td><?php echo number_format($product->retail_price,2); ?></td>
                                        <td><?php echo number_format($product->sale_price,2); ?></td>
                                        <td><?php echo $product->discount_type; ?></td>
                                        <td><?php echo $product->discount_type == 'Percent' ? $product->discount : number_format($product->discount,0); ?></td>
                                        <td><?php echo number_format($product->total_price,2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <hr />

                <div>
                    Feedback: 
                    <?php echo CHtml::activeTextArea($registrationTransaction, 'feedback', array('rows' => 5)); ?>
                </div>
                
                <br /><br />

                <div>
                    Note: 
                    <?php echo CHtml::activeTextArea($registrationTransaction, 'note', array('rows' => 5)); ?>
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