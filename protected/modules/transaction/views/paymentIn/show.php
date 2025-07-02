<?php
/* @var $this PaymentInController */
/* @var $model PaymentIn */

$this->breadcrumbs = array(
    'Payment Ins' => array('index'),
    $model->id,
);
?>

<?php echo CHtml::beginForm(); ?>
<div id="maincontent">
    <h1>View Payment In #<?php echo $model->id; ?></h1>
    
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
                                    <span class="prefix">Payment Type</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->paymentType->name; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Company Bank</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo CHtml::encode(CHtml::value($model, 'companyBank.account_name')); ?>"> 
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
                                    <span class="prefix">Notes</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <textarea name="" id="" cols="30" rows="4" readonly="true"><?php echo $model->notes; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="large-6 columns">
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
                                    <span class="prefix">Insurance Company</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo CHtml::encode(CHtml::value($model, 'insuranceCompany.name')); ?>"> 
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">User Created</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <?php echo CHtml::encode(CHtml::value($model, 'user.username')); ?>
                                </div>
                            </div>
                        </div>
                        
                        <?php if (Yii::app()->user->checkAccess("director")): ?>
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Date Created</span>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(CHtml::value($model, 'created_datetime')); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">User Edited</span>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(CHtml::value($model, 'userIdEdited.username')); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Date Edited</span>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(CHtml::value($model, 'edited_datetime')); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">User Cancelled</span>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(CHtml::value($model, 'userIdCancelled.username')); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Date Cancelled</span>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(CHtml::value($model, 'cancelled_datetime')); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>                        
                    </div>
                </div>
            </fieldset>
            
            <?php if (!empty($model->customer_id)): ?>
                <fieldset>
                    <legend>Customer</legend>
                    <div class="large-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Name</span>
                                </div>

                                <div class="small-8 columns">
                                    <input type="text" readonly="true" id="Customer_customer_name" value="<?php echo CHtml::encode(CHtml::value($model, 'customer.name')); ?>"> 
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
                                    <textarea name="" id="Customer_phones" cols="30" rows="5" readonly="true"><?php echo CHtml::encode(CHtml::value($model, 'customer.phone')); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Mobile</span>
                                </div>

                                <div class="small-8 columns">
                                    <textarea name="" id="Customer_mobiles" cols="30" rows="5" readonly="true"><?php echo CHtml::encode(CHtml::value($model, 'customer.mobile_phone')) ?></textarea>
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
            <?php endif; ?>
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
                <legend>Payment Detail</legend>
                <div id="invoice-Detail">
                    <table>
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Customer</th>
                                <th>Asuransi</th>
                                <th>Memo</th>
                                <th>Total Invoice</th>
                                <th>Pph</th>
                                <th>Disc</th>
                                <th>Biaya Bank</th>
                                <th>Biaya Merimen</th>
                                <th>DP</th>
                                <th>Payment Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($model->paymentInDetails as $detail): ?>
                            <tr>
                                <td><?php echo CHtml::link($detail->invoiceHeader->invoice_number, array("/transaction/invoiceHeader/show", "id" => $detail->invoice_header_id), array('target' => 'blank')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($detail, 'invoiceHeader.customer.name')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($detail, 'invoiceHeader.insuranceCompany.name')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total_invoice'))); ?>
                                </td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'tax_service_amount'))); ?>
                                </td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'discount_amount'))); ?>
                                </td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'bank_administration_fee'))); ?>
                                </td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'merimen_fee'))); ?>
                                </td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'downpayment_amount'))); ?>
                                </td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'amount'))); ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="text-align: right" colspan="10">Total Amount + Pph</td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, 'totalDetail'))); ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right" colspan="10">Diskon</td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, 'discount_product_amount'))); ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right" colspan="10">Beban Administrasi Bank</td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, 'bank_administration_fee'))); ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right" colspan="10">Beban Merimen</td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, 'merimen_fee'))); ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right" colspan="10">Downpayment</td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, 'downpayment_amount'))); ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right" colspan="10">Biaya Bank</td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, 'bank_fee_amount'))); ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right" colspan="10">Total Payment</td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, 'totalPayment'))); ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right" colspan="10">Total Invoice</td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, 'totalInvoice'))); ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
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
                <legend>Attached Images</legend>

                <?php if (!empty($postImages)): ?>
                    <?php $postImage = $postImages[count($postImages) - 1]; ?>
                    <?php $src = Yii::app()->baseUrl . '/images/uploads/paymentIn/' . $postImage->filename; ?>
                    <div class="row">
                        <div class="small-3 columns">
                            <div style="margin-bottom:.5rem">
                                <?php echo CHtml::image($src, $model->payment_number . "Image"); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </fieldset>
            
            <br />

            <?php $transactions = JurnalUmum::model()->findAllByAttributes(array('kode_transaksi' => $model->payment_number, 'is_coa_category' => 0)); ?>
            <?php if (Yii::app()->user->checkAccess("paymentInSupervisor")): ?>
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
                            <?php foreach ($transactions as $i => $header): ?>

                                <?php $amountDebit = $header->debet_kredit == 'D' ? CHtml::value($header, 'total') : 0; ?>
                                <?php $amountCredit = $header->debet_kredit == 'K' ? CHtml::value($header, 'total') : 0; ?>

                                <tr>
                                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                                    <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountCode')); ?></td>
                                    <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountName')); ?></td>
                                    <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $amountDebit)); ?></td>
                                    <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $amountCredit)); ?></td>
                                </tr>

                                <?php $totalDebit += $amountDebit; ?>
                                <?php $totalCredit += $amountCredit; ?>

                            <?php endforeach; ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align: right; font-weight: bold">TOTAL</td>
                                <td class="width1-6" style="text-align: right; font-weight: bold; border-top: 1px solid">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalDebit)); ?>
                                </td>
                                <td class="width1-7" style="text-align: right; font-weight: bold; border-top: 1px solid">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalCredit)); ?>
                                </td>
                            </tr>        
                        </tfoot>
                    </table>
                </fieldset>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php echo CHtml::endForm(); ?>