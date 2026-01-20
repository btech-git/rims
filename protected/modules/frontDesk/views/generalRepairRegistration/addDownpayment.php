<?php
/* @var $this RegistrationTransactionController */
/* @var $generalRepairRegistration->header RegistrationTransaction */

$this->breadcrumbs = array(
    'General Repair Transactions' => array('admin'),
    $generalRepairRegistration->header->id,
);
?>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'downpayment-form',
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'enableAjaxValidation'=>false,
)); ?>
            <?php echo $form->errorSummary($generalRepairRegistration->header); ?>
<div class="small-12 columns">
    <div id="maincontent">
        <div class="clearfix page-action">
            <?php $ccontroller = Yii::app()->controller->id; ?>
            <?php $ccaction = Yii::app()->controller->action->id; ?>

            <h1>Add DP Transaction #<?php echo $generalRepairRegistration->header->transaction_number; ?></h1>

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
                                        <input type="text" readonly="true" value="<?php echo $generalRepairRegistration->header->transaction_number; ?>"> 
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Transaction Date</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" value="<?php echo Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", strtotime($generalRepairRegistration->header->transaction_date)); ?>"> 
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Customer</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" value="<?php echo $generalRepairRegistration->header->customer->name; ?>"> 
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Customer Type</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" value="<?php echo $generalRepairRegistration->header->customer->customer_type; ?>"> 
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Repair Type</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" value="<?php echo $generalRepairRegistration->header->repair_type; ?>"> 
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Status</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" value="<?php echo $generalRepairRegistration->header->status; ?>"> 
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Service Status</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" value="<?php echo $generalRepairRegistration->header->service_status; ?>"> 
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Sales</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" value="<?php echo !empty($generalRepairRegistration->header->employee_id_sales_person) ? $generalRepairRegistration->header->employeeIdSalesPerson->name : ''; ?>"> 
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Problem</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <textarea name="" id="" cols="30" rows="5" readonly="true"><?php echo $generalRepairRegistration->header->problem; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <?php if ($generalRepairRegistration->header->is_insurance == 1): ?>
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">Insurance Company</span>
                                        </div>
                                        <div class="small-8 columns">
                                            <input type="text" readonly="true" value="<?php echo $generalRepairRegistration->header->insuranceCompany->name; ?>"> 
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div> <!-- end div large -->

                        <div class="large-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Plate #</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" value="<?php echo $generalRepairRegistration->header->vehicle->plate_number; ?>"> 
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Kendaraan</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" value="<?php echo $generalRepairRegistration->header->vehicle->carMakeModelSubCombination; ?>"> 
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Warna</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php $color = Colors::model()->findByPK($generalRepairRegistration->header->vehicle->color_id); ?>
                                        <input type="text" readonly="true" value="<?php echo $color->name; ?>"> 
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">KM</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" value="<?php echo $generalRepairRegistration->header->vehicle_mileage; ?>"> 
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">SO #</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" value="<?php echo $generalRepairRegistration->header->sales_order_number; ?>"> 
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">SO Date</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" value="<?php echo $generalRepairRegistration->header->sales_order_date; ?>"> 
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">WO #</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" value="<?php echo $generalRepairRegistration->header->work_order_number; ?>"> 
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">WO date</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" value="<?php echo $generalRepairRegistration->header->work_order_date; ?>"> 
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Status Barang</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" value="<?php echo ($generalRepairRegistration->header->totalQuantityMovementLeft > 0) ? 'Pending' : 'Completed'; ?>"> 
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Status Service</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" value="<?php echo $generalRepairRegistration->header->service_status; ?>"> 
                                    </div>
                                </div>
                            </div>
                        </div><!-- end div large -->
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
    
    <div class="detail">
        <fieldset>
            <legend>Details</legend>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Service name</th>
                        <th>Note</th>
                        <th>Price</th>
                        <th>Discount Type</th>
                        <th>Discount Price</th>
                        <th>Total Price</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (count($services) > 0): ?>
                        <?php foreach ($services as $i => $service): ?>
                            <tr>
                                <td><?php echo $service->service_id; ?></td>
                                <td><?php echo $service->service->name; ?></td>
                                <td><?php echo $service->note; ?></td>
                                <td style="text-align:right"><?php echo number_format($service->price,2); ?></td>
                                <td><?php echo $service->discount_type; ?></td>
                                <td style="text-align:right"><?php echo $service->discount_type == 'Percent' ? $service->discount_price : number_format($service->discount_price,2);; ?></td>
                                <td style="text-align:right"><?php echo number_format($service->total_price,2); ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Product name</th>
                        <th>Quantity</th>
                        <th>Satuan</th>
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
                                <td><?php echo $product->product_id; ?></td>
                                <td><?php echo $product->product->manufacturer_code; ?></td>
                                <td><?php echo $product->product->name; ?></td>
                                <td style="text-align: center"><?php echo $product->quantity; ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($product, 'product.unit.name')); ?></td>
                                <td style="text-align:right"><?php echo number_format($product->retail_price,2); ?></td>
                                <td style="text-align:right"><?php echo number_format($product->sale_price,2); ?></td>
                                <td><?php echo $product->discount_type; ?></td>
                                <td style="text-align:right"><?php echo $product->discount_type == 'Percent' ? $product->discount : number_format($product->discount,0); ?></td>
                                <td style="text-align:right"><?php echo number_format($product->total_price,2); ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
            
            <table>
                <tr>
                    <td style="text-align:right; width: 85%">Sub Total</td>
                    <td style="text-align:right; width: 15%"><?php echo number_format($generalRepairRegistration->header->subtotal,2); ?></td>
                </tr>
                <tr>
                    <td style="text-align:right">PPn</td>
                    <td style="text-align:right"><?php echo number_format($generalRepairRegistration->header->ppn_price,2); ?></td>
                </tr>
                <tr>
                    <td style="text-align:right">Grand Total</td>
                    <td style="text-align:right"><?php echo number_format($generalRepairRegistration->header->grand_total,2); ?></td>
                </tr>
                <tr>
                    <td style="text-align:right">Downpayment</td>
                    <td><?php echo CHtml::activeTextField($generalRepairRegistration->header, 'downpayment_amount'); ?></td>
                </tr>
                <tr>
                    <td style="text-align:right">Note</td>
                    <td><?php echo CHtml::activeTextArea($generalRepairRegistration->header, 'downpayment_note'); ?></td>
                </tr>
            </table>
        </fieldset>
    </div>
    
    <hr />

    <div class="field buttons text-center">
        <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class'=>'button cbutton')); ?> 
    </div>
    <?php echo IdempotentManager::generate(); ?>
</div>

<?php $this->endWidget(); ?>