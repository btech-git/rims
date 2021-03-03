<?php
/* @var $this PaymentInController */
/* @var $model PaymentIn */

$this->breadcrumbs = array(
    'Payment Ins' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List PaymentIn', 'url' => array('index')),
    array('label' => 'Create PaymentIn', 'url' => array('create')),
    array('label' => 'Update PaymentIn', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete PaymentIn', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage PaymentIn', 'url' => array('admin')),
);
?>

<?php echo CHtml::beginForm(); ?>
<!--<h1>View PaymentIn #<?php echo $model->id; ?></h1>-->
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
            <!-- <a class="button cbutton right" style="margin-right:10px;" href="#"><span class="fa fa-th-list"></span>Manage PaymentIn</a> -->
        <?php echo CHtml::link('<span class="fa fa-th-list"></span>Manage Payment In', Yii::app()->baseUrl . '/transaction/paymentIn/admin', array('class' => 'button cbutton right', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("transaction.paymentIn.admin"))) ?>
        <?php if (!($model->status == 'Approved' || $model->status == 'Rejected')): ?>
            <?php //echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl.'/transaction/paymentIn/update?id=' . $model->id, array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.paymentIn.update"))) ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl . '/transaction/paymentIn/updateApproval?headerId=' . $model->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("transaction.paymentIn.updateApproval"))) ?>
        <?php endif ?>
        
        <?php if ($model->invoice->registrationTransaction->status != 'Finished'): ?>
            <?php echo CHtml::submitButton('Finish', array('name' => 'SubmitFinish', 'confirm' => 'Are you sure you want to finish this transaction?', 'class' => 'button warning')); ?>
        <?php endif; ?>
        
        <h1>View Payment In #<?php echo $model->id; ?></h1>
    </div>
    
    <div class="row">
        <div class="large-12 columns">
            <fieldset>
                <legend>Payment</legend>
                <div class="row">
                    <div class="large-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Payment #</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->payment_number; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Payment Date</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->payment_date; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Payment Amount</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo AppHelper::formatMoney($model->payment_amount); ?>">
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
                    </div>

                    <div class="large-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">User</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->user->username; ?>"> 
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Branch</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->branch->name; ?>"> 
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Notes</span>
                                </div>
                                <div class="small-8 columns">
                                    <textarea name="" id="" cols="30" rows="4" readonly="true"><?php echo $model->notes; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            
            <fieldset>
                <legend>Approval Status</legend>
                <table>
                    <thead>
                        <tr>
                            <th>Approval type</th>
                            <th>Revision</th>
                            <th>date</th>
                            <th>note</th>
                            <th>supervisor</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach ($revisionHistories as $key => $history): ?>
                            <tr>
                                <td><?php echo $history->approval_type; ?></td>
                                <td><?php echo $history->revision; ?></td>
                                <td><?php echo $history->date; ?></td>
                                <td><?php echo $history->note; ?></td>
                                <td><?php echo $history->supervisor->username; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </fieldset>

            <fieldset>
                <h1>Invoice Detail</h1>
                <div id="invoice-Detail">
                    <fieldset>
                        <legend>Invoice # <?php echo $model->invoice->invoice_number ?></legend>
                        <div class="large-4 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Invoice Date</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true"  value="<?php echo $model->invoice_id != "" ? $model->invoice->invoice_date : '' ?>" > 
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
                        <?php
                        $referenceNum = "";
                        $referenceType = "";
                        if ($model->invoice->reference_type == 1) {
                            $referenceType = 'Sales Order';
                            $referenceNum = $model->invoice->salesOrder->sale_order_no;
                        } else {
                            $referenceType = 'Retail Sales';
                            $referenceNum = $model->invoice->registrationTransaction->transaction_number;
                        }
                        ?>
                        <div class="large-4 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Reference Type</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" id="Invoice_reference_type" value="<?php echo $model->invoice_id != "" ? $referenceType : '' ?>"> 
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Reference Number</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" id="Invoice_reference_number" value="<?php echo $model->invoice_id != "" ? $referenceNum : '' ?>"> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="large-4 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Invoice Amount</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" id="Invoice_total_price" value="<?php echo $model->invoice ? AppHelper::formatMoney($model->invoice->total_price) : '' ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Payment Amount</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" value="<?php echo $model->invoice ? AppHelper::formatMoney($model->invoice->payment_amount) : '0' ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Payment Left</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" value="<?php echo $model->invoice ? AppHelper::formatMoney($model->invoice->payment_left) : '0' ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Payment History</legend>
                        <div class="large-12 columns">
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

                    <fieldset>
                        <legend>Customer</legend>
                        <div class="large-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Name</span>
                                    </div>
                                    <div class="small-8 columns">

                                        <input type="text" readonly="true" id="Customer_customer_name" value="<?php echo $model->invoice_id != "" ? $model->customer->name : '' ?>"> 
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Type</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" id="Customer_customer_type" value="<?php echo $model->customer_id != "" ? $model->customer->customer_type : '' ?>"> 
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Address</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <textarea name="" id="Customer_customer_address" cols="30" rows="5" readonly="true"><?php echo $model->customer_id != "" ? $model->customer->address . '&#13;&#10;' . $model->customer->province->name . '&#13;&#10;' . $model->customer->city->name . '&#13;&#10;' . $model->customer->zipcode : ''; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end div large -->

                        <div class="large-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Phone</span>
                                    </div>
                                    
                                    <div class="small-8 columns">
                                        <?php $getPhone = ""; ?>
                                        <?php if ($model->customer_id != ""): ?>
                                            <?php $phones = CustomerPhone::model()->findAllByAttributes(array('customer_id' => $model->customer_id, 'status' => 'Active')); ?>

                                            <?php if (count($phones) > 0): ?>
                                                <?php foreach ($phones as $key => $phone): ?>
                                                    <?php $getPhone = $phone->phone_no . '&#13;&#10;'; ?>
                                                <?php endforeach ?>
                                            <?php endif; ?>

                                        <?php endif; ?>
                                        <textarea name="" id="Customer_phones" cols="30" rows="5" readonly="true"><?php echo $getPhone; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Mobile</span>
                                    </div>
                                    
                                    <div class="small-8 columns">
                                        <?php $getMobile = "" ?>
                                        <?php if ($model->customer_id != ""): ?>
                                            <?php $mobiles = CustomerMobile::model()->findAllByAttributes(array('customer_id' => $model->customer_id, 'status' => 'Active')); ?>

                                            <?php if (count($mobiles) > 0): ?>
                                                <?php foreach ($mobiles as $key => $mobile): ?>
                                                    <?php $getMobile .= $mobile->mobile_no . '&#13;&#10;'; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <textarea name="" id="Customer_mobiles" cols="30" rows="5" readonly="true"><?php echo $getMobile ?></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Email</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" id="Customer_email" value="<?php echo $model->customer_id != "" ? $model->customer->email : ''; ?>"> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <?php if ($model->vehicle_id != ""): ?>
                        <fieldset>
                            <legend>Vehicle</legend>

                            <?php
                            $vehicleId = $plate = $machine = $frame = $chasis = $power = $carMake = $carModel = $carSubModel = $carColor = "";
                            if ($model->vehicle_id != "") {
                                $vehicle = Vehicle::model()->findByPk($model->vehicle_id);
                                if (!empty($vehicle)) {
                                    $vehicleId = $vehicle->id;
                                    $plate = $vehicle->plate_number != "" ? $vehicle->plate_number : '';
                                    $machine = $vehicle->machine_number != "" ? $vehicle->machine_number : '';
                                    $frame = $vehicle->frame_number != "" ? $vehicle->frame_number : '';
                                    $chasis = $vehicle->chasis_code != "" ? $vehicle->chasis_code : '';
                                    $power = $vehicle->power != "" ? $vehicle->power : '';
                                    $carMake = $vehicle->car_make_id != "" ? $vehicle->carMake->name : '';
                                    $carModel = $vehicle->car_model_id != "" ? $vehicle->carModel->name : '';
                                    $carSubModel = $vehicle->car_sub_model_detail_id != "" ? $vehicle->carSubModel->name : '';
                                    $carColor = $vehicle->color_id != "" ? Colors:: model()->findByPk($vehicle->color_id)->name : '';
                                }
                            }
                            ?>
                            <div class="large-6 columns">
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">Plate Number</span>
                                        </div>
                                        <div class="small-8 columns">

                                            <input type="text" readonly="true" id="Vehicle_plate_number" value="<?php echo $plate != "" ? $plate : ''; ?>"> 
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">Machine Number</span>
                                        </div>
                                        <div class="small-8 columns">
                                            <input type="text" readonly="true" id="Vehicle_machine_number" value="<?php echo $machine != "" ? $machine : ''; ?>"> 
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">Frame Number</span>
                                        </div>
                                        <div class="small-8 columns">
                                            <input type="text" readonly="true" id="Vehicle_frame_number" value="<?php echo $frame != "" ? $frame : ''; ?>"> 
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">Chasis Code</span>
                                        </div>
                                        <div class="small-8 columns">
                                            <input type="text" readonly="true" id="Vehicle_chasis_code" value="<?php echo $chasis != "" ? $chasis : ''; ?>"> 


                                        </div>
                                    </div>
                                </div>
                                
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">Power CC</span>
                                        </div>
                                        <div class="small-8 columns">
                                            <input type="text" readonly="true" id="Vehicle_power" value="<?php echo $power != "" ? $power : ''; ?>"> 
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end div large -->

                            <div class="large-6 columns">
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">Car Make</span>
                                        </div>
                                        <div class="small-8 columns">
                                            <input type="text" readonly="true" id="Vehicle_car_make_name" value="<?php echo $carMake != "" ? $carMake : ''; ?>"> 
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">Car Model</span>
                                        </div>
                                        
                                        <div class="small-8 columns">
                                            <input type="text" readonly="true" id="Vehicle_car_model_name" value="<?php echo $carModel != "" ? $carModel : ''; ?>"> 
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">Car Sub Model</span>
                                        </div>
                                        
                                        <div class="small-8 columns">
                                            <input type="text" readonly="true" id="Vehicle_car_sub_model_name" value="<?php echo $carSubModel != "" ? $carSubModel : ''; ?>"> 
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">Color</span>
                                        </div>
                                        
                                        <div class="small-8 columns">
                                            <input type="text" readonly="true" id="Vehicle_car_color_name" value="<?php echo $carColor != "" ? $carColor : ''; ?>"> 
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end div large -->
                        </fieldset>
                    <?php endif; ?>
                    
                    <fieldset>
                        <legend>Attached Images</legend>

                        <?php foreach ($postImages as $postImage):
                            $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/paymentIn/' . $model->id . '/' . $postImage->filename;
                            $src = Yii::app()->baseUrl . '/images/uploads/paymentIn/' . $model->id . '/' . $postImage->filename;
                        ?>
                            <div class="row">
                                <div class="small-3 columns">
                                    <div style="margin-bottom:.5rem">
                                        <?php echo CHtml::image($src, $model->payment_number . "Image"); ?>
                                    </div>
                                </div>
                                
                                <div class="small-8 columns">
                                    <div style="padding:.375rem .5rem; border:1px solid #ccc; background:#fff; font-size:.8125rem; line-height:1.4; margin-bottom:.5rem;">
                                        <?php echo (Yii::app()->baseUrl . '/images/uploads/paymentIn/' . $model->id . '/' . $postImage->filename); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </fieldset>
                </div>
            </fieldset>
            
            <br />

            <fieldset>
                <legend>Journal Transactions</legend>
                <table class="report">
                    <thead>
                        <tr id="header1">
                            <th style="width: 5%">No</th>
                            <th style="width: 15%">Kode COA</th>
                            <th>Nama COA</th>
                            <th style="width: 15%">Debit</th>
                            <th style="width: 15%">Kredit</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $totalDebit = 0; $totalCredit = 0; ?>
                        <?php $transactions = JurnalUmum::model()->findAllByAttributes(array('kode_transaksi' => $model->payment_number, 'is_coa_category' => 0)); ?>
                        <?php foreach ($transactions as $i => $header): ?>

                            <?php $amountDebit = $header->debet_kredit == 'D' ? CHtml::value($header, 'total') : 0; ?>
                            <?php $amountCredit = $header->debet_kredit == 'K' ? CHtml::value($header, 'total') : 0; ?>

                            <tr>
                                <td style="text-align: center"><?php echo $i + 1; ?></td>
                                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountCode')); ?></td>
                                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountName')); ?></td>
                                <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountDebit)); ?></td>
                                <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountCredit)); ?></td>
                            </tr>

                            <?php $totalDebit += $amountDebit; ?>
                            <?php $totalCredit += $amountCredit; ?>

                        <?php endforeach; ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: right; font-weight: bold">TOTAL</td>
                            <td class="width1-6" style="text-align: right; font-weight: bold; border-top: 1px solid"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalDebit)); ?></td>
                            <td class="width1-7" style="text-align: right; font-weight: bold; border-top: 1px solid"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalCredit)); ?></td>
                        </tr>        
                    </tfoot>
                </table>
            </fieldset>

            <br />

        </div>
    </div>
</div>
<?php echo CHtml::endForm(); ?>
