<?php
/* @var $this InvoiceHeaderController */
/* @var $model InvoiceHeader */

$this->breadcrumbs = array(
    'Invoice Headers' => array('admin'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List InvoiceHeader', 'url' => array('index')),
    array('label' => 'Create InvoiceHeader', 'url' => array('create')),
    array('label' => 'Update InvoiceHeader', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete InvoiceHeader', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage InvoiceHeader', 'url' => array('admin')),
);
?>

<?php echo CHtml::beginForm(); ?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>

        <?php if ($model->status !== 'CANCELLED!!!'): ?>
            <?php if (Yii::app()->user->checkAccess("saleInvoiceSupervisor")): ?>
                <?php echo CHtml::link('<span class="fa fa-minus"></span>Cancel Transaction', array("/transaction/invoiceHeader/cancel", "id" => $model->id), array(
                    'class' => 'button alert right', 
                    'style' => 'margin-right:10px', 
                )); ?>
            <?php endif; ?>
            <?php if ($model->payment_left > 0.00): ?>
                <?php echo CHtml::link('<span class="fa fa-plus"></span>Payment', array("/transaction/paymentIn/create", "invoiceId" => $model->id), array(
                    'class' => 'button success right', 
                    'style' => 'margin-right:10px', 
                )); ?>
            <?php endif; ?>
        <?php endif; ?>
        
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Invoices', Yii::app()->baseUrl . '/transaction/invoiceHeader/admin', array(
            'class' => 'button cbutton right', 
            'style' => 'margin-right:10px', 
        )); ?>
        
        <?php //if ($model->status == "Draft" && Yii::app()->user->checkAccess("invoiceApproval")): ?>
            <?php /*echo CHtml::link('<span class="fa fa-edit"></span>Approval', Yii::app()->baseUrl . '/transaction/invoiceHeader/updateApproval?id=' . $model->id, array(
                'class' => 'button cbutton right', 
                'style' => 'margin-right:10px'
            ));*/ ?>
        <?php //elseif ($model->status != "Draft" && Yii::app()->user->checkAccess("invoiceSupervisor")): ?>
            <?php //echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl . '/transaction/paymentIn/updateApproval?headerId=' . $model->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px')) ?>
        <?php //endif; ?>

        <?php if ($model->status != 'PAID'): ?> 
            <?php echo CHtml::link('<span class="fa fa-print"></span>Print Invoice', array("pdf", "id" => $model->id), array(
                'class' => 'button warning right', 
                'style' => 'margin-right:10px', 
            )); ?>
        <?php else: ?>
            <?php echo CHtml::link('<span class="fa fa-print"></span>Print Tanda Terima', array("pdfPayment", "id" => $model->id), array(
                    'class' => 'button warning right', 
                    'style' => 'margin-right:10px', 
                )); ?>
        <?php endif; ?>

        <h1>View Invoice #<?php echo $model->invoice_number; ?></h1>

        <table>
            <?php $registration = RegistrationTransaction::model()->findByPk($model->registration_transaction_id); ?>
            <tr>
                <td>Invoice Number</td>
                <td><?php echo $model->invoice_number; ?></td>
                <td width="10%">Invoice Status</td>
                <td width="30%">
                    <input type="text" id = "status" style="background-color:red;color:white" value="<?php echo $model->status; ?>">
                </td>
            </tr>
            
            <tr>
                <td>Customer</td>
                <td><?php echo CHtml::encode(CHtml::value($model, 'customer.name')); ?></td>
                <td>Reference Type</td>
                <td><?php echo $model->reference_type == 1 ? 'Sales Order' : 'Retail Sales'; ?></td>
            </tr>
            
            <tr>
                <td>Invoice Date</td>
                <td><?php echo $model->invoice_date; ?></td>
                <td width="10%">SO #</td>
                <td width="30%">
                    <?php echo CHtml::encode(CHtml::value($registration, 'sales_order_number')); ?>
                </td>
            </tr>
            
            <tr>
                <td>Due Date</td>
                <td><?php echo $model->due_date; ?></td>
                <td width="10%">Registration #</td>
                <td width="30%"><?php echo CHtml::link($registration->transaction_number, array($registration->repair_type == 'GR' ? "/frontDesk/generalRepairRegistration/show" : "/frontDesk/bodyRepairRegistration/show", "id"=>$registration->id), array('target' => 'blank')); ?></td>
            </tr>
            
            <tr>
                <td width="10%">Payment Est Date</td>
                <td width="30%"><?php echo $model->payment_date_estimate; ?></td>
                <td width="10%">Plate #</td>
                <td width="30%"><?php echo CHtml::encode(CHtml::value($model, 'vehicle.plate_number')); ?>
                </td>
            </tr>
            
            <tr>
                <td width="10%">Insurance Company</td>
                <td width="30%">
                    <?php echo CHtml::encode(CHtml::value($model, 'insuranceCompany.name')); ?>
                </td>
                <td width="10%">Car Make</td>
                <td width="30%"><?php echo CHtml::encode(CHtml::value($model, 'vehicle.carMake.name')); ?></td>
            </tr>
            
            <tr>
                <td width="10%">Repair Type</td>
                <td width="30%"><?php echo CHtml::encode(CHtml::value($model, 'registrationTransaction.repair_type')); ?></td>
                <td width="10%">Car Model</td>
                <td width="30%">
                    <?php echo CHtml::encode(CHtml::value($model, 'vehicle.carModel.name')); ?>
                </td>
            </tr>
            
            <tr>
                <td>Reference Number</td>
                <td><?php if ($model->reference_type == 1): ?>
                        <?php echo $model->salesOrder->sale_order_no; ?>
                    <?php else : ?>
                        <?php echo $model->registration_transaction_id; ?>
                    <?php endif ?>
                </td>
                <td width="10%">Car Detail</td>
                <td width="30%"><?php echo CHtml::encode(CHtml::value($model, 'vehicle.carSubModel.name')); ?></td>
            </tr>
                
            <?php if (Yii::app()->user->checkAccess("director")): ?>
                <tr>
                    <td width="10%">User Created</td>
                    <td width="30%"><?php echo CHtml::encode(CHtml::value($model, 'user.username')); ?></td>
                    <td width="10%">Date Created</td>
                    <td width="30%"><?php echo CHtml::encode(CHtml::value($model, 'created_datetime')); ?></td>
                </tr>

                <tr>
                    <td width="10%">User Edited</td>
                    <td width="30%"><?php echo CHtml::encode(CHtml::value($model, 'userIdEdited.username')); ?></td>
                    <td width="10%">Date Edited</td>
                    <td width="30%"><?php echo CHtml::encode(CHtml::value($model, 'edited_datetime')); ?></td>
                </tr>

                <tr>
                    <td width="10%">User Cancelled</td>
                    <td width="30%"><?php echo CHtml::encode(CHtml::value($model, 'userIdCancelled.username')); ?></td>
                    <td width="10%">Date Cancelled</td>
                    <td width="30%"><?php echo CHtml::encode(CHtml::value($model, 'cancelled_datetime')); ?></td>
                </tr>
            <?php endif; ?>
        </table>
        
        <?php
        $productCriteria = new CDbCriteria;
        $productCriteria->addCondition('invoice_id =' . $model->id);
        $productCriteria->addCondition('product_id != ""');
        $products = InvoiceDetail::model()->findAll($productCriteria);
        ?>
        
        <?php
        $serviceCriteria = new CDbCriteria;
        $serviceCriteria->addCondition('invoice_id =' . $model->id);
        $serviceCriteria->addCondition('service_id != ""');
        $services = InvoiceDetail::model()->findAll($serviceCriteria);
        ?>
        
        <?php
        $QserviceCriteria = new CDbCriteria;
        $QserviceCriteria->addCondition('invoice_id =' . $model->id);
        $QserviceCriteria->addCondition('quick_service_id != ""');
        $Qservices = InvoiceDetail::model()->findAll($QserviceCriteria);
        ?>
        <fieldset>
            <legend>Details</legend>
            <?php if (count($products) > 0) : ?>
                <table>
                    <thead>
                        <th style="text-align: center">ID</th>
                        <th style="text-align: center">Code</th>
                        <th style="text-align: center">Product</th>
                        <th style="text-align: center">Quantity</th>
                        <th style="text-align: center">Unit Price</th>
                        <th style="text-align: center">Discount</th>
                        <th style="text-align: center">Total</th>
                    </thead>
                    
                    <tbody>
                        <?php foreach ($details as $i => $detail): ?>
                            <?php if ($detail->product_id != ""): ?>
                                <tr>
                                    <td><?php echo $detail->product->id; ?></td>
                                    <td><?php echo $detail->product->manufacturer_code; ?></td>
                                    <td><?php echo $detail->product->name; ?></td>
                                    <td style="text-align: center"><?php echo $detail->quantity; ?></td>
                                    <td style="text-align: right"><?php echo number_format($detail->unit_price, 2); ?></td>
                                    <td style="text-align: right"><?php echo number_format($detail->discount, 2); ?></td>
                                    <td style="text-align: right"><?php echo number_format($detail->total_price, 2); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
            
            <?php if (count($services) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th style="text-align: center">ID</th>
                            <th style="text-align: center">Service</th>
                            <th style="text-align: center">Type</th>
                            <th style="text-align: center">Price</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach ($details as $i => $detail): ?>
                            <?php if ($detail->service_id != ""): ?>
                                <tr>
                                    <td><?php echo $detail->service->id; ?></td>
                                    <td><?php echo $detail->service->name; ?></td>
                                    <td><?php echo $detail->service->serviceType->name; ?></td>
                                    <td style="text-align: right"><?php echo number_format($detail->total_price, 2); ?></td>
                                </tr>
                            <?php endif ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
            
            <?php if (count($Qservices) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Quick Service</th>
                            <th>Unit Price</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach ($details as $i => $detail): ?>
                            <?php if ($detail->quick_service_id != ""): ?>
                                <tr>
                                    <td><?php echo $detail->quickService->name; ?></td>
                                    <td><?php echo number_format($detail->unit_price, 2); ?></td>
                                    <td><?php echo number_format($detail->total_price, 2); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
            
            <style type="text/css">
                .totalTable{
                    width:30% !important;float:right; border:none;background-color: white;
                }
                .totalTable tr td
                {
                    border:none;
                    background-color: white;
                }
                .title{
                    font-weight: bold;
                }
            </style>
            <table class="totalTable">
                <?php if ($model->reference_type == 2): ?>
                    <tr>
                        <td class="title">Service Price</td>
                        <td>Rp. <?php echo number_format($model->service_price, 2); ?></td>
                    </tr>
                <?php endif; ?>

                <tr>
                    <td class="title"><?php echo $model->reference_type == 1 ? 'Subtotal' : 'Product Price' ?></td>
                    <td>Rp. <?php echo number_format($model->product_price, 2) ?></td>
                </tr>
                
                <?php if ($model->reference_type == 2): ?>
                    <tr>
                        <td class="title">Quick Service Price</td>
                        <td>Rp. <?php echo number_format($model->quick_service_price, 2); ?></td>
                    </tr>
                <?php endif; ?>
                    
                <tr>
                    <td class="title">Sub Total</td>
                    <td>Rp. <?php echo number_format($model->subTotal, 2) ?></td>
                </tr>
                
                <tr>
                    <td class="title">PPN <?php echo CHtml::encode(CHtml::value($model, 'tax_percentage')); ?>%</td>
                    <td>Rp. <?php echo number_format($model->ppn_total, 2); ?></td>
                </tr>

                <?php if ($model->reference_type == 2): ?>
                    <tr>
                        <td class="title">PPH (2%) </td>
                        <td>Rp. <?php echo number_format($model->pph_total, 2) ?></td>
                    </tr>
                <?php endif; ?>

                <tr>
                    <td class="title">Total Price</td>
                    <td><strong>Rp. <?php echo number_format($model->total_price, 2) ?></strong></td>
                </tr>	

                <tr>
                    <td class="title">Total Payment</td>
                    <td><strong>Rp. <?php echo number_format($model->payment_amount, 2) ?></strong></td>
                </tr>	

                <tr>
                    <td class="title">Remaining Receivable</td>
                    <td><strong>Rp. <?php echo number_format($model->payment_left, 2) ?></strong></td>
                </tr>
            </table>
        </fieldset>

        <fieldset>
            <legend>Payment Details</legend>
            <?php if (count($payments) > 0): ?>
                <table>
                    <thead>
                        <th>Payment Number</th>
                        <th>Payment Date</th>
                        <th>Payment Type</th>
                        <th>Payment Amount</th>
                        <th>Notes</th>
                        <th>Stat</th>
                    </thead>
                    
                    <tbody>
                        <?php foreach ($payments as $key => $payment): ?>
                            <tr>
                                <td><?php echo CHtml::link($payment->paymentIn->payment_number, array("/transaction/paymentIn/show", "id"=>$payment->payment_in_id), array('target' => 'blank')); ?></td>
                                <td><?php echo $payment->paymentIn->payment_date; ?></td>
                                <td><?php echo $payment->paymentIn->paymentType->name; ?></td>
                                <td><?php echo number_format($payment->amount, 2); ?></td>
                                <td><?php echo $payment->paymentIn->notes; ?></td>
                                <td><?php echo $payment->paymentIn->status; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <?php echo "No Payment For this Invoice."; ?>
            <?php endif ?>
        </fieldset>
        
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
                
                <?php $transactionInvoices = JurnalUmum::model()->findAllByAttributes(array('kode_transaksi' => $model->invoice_number, 'is_coa_category' => 0)); ?>
                <?php $transactionRegistrations = JurnalUmum::model()->findAllByAttributes(array('kode_transaksi' => $model->registrationTransaction->transaction_number, 'is_coa_category' => 0)); ?>
                <?php $transactions = empty($transactionInvoices) ? $transactionRegistrations : $transactionInvoices; ?>
                
                <?php if (!empty($transactions)): ?>
                    <?php foreach ($transactions as $i => $header): ?>

                        <?php $amountDebit = $header->debet_kredit == 'D' ? CHtml::value($header, 'total') : 0; ?>
                        <?php $amountCredit = $header->debet_kredit == 'K' ? CHtml::value($header, 'total') : 0; ?>

                        <tr>
                            <td style="text-align: center"><?php echo $i + 1; ?></td>
                            <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountCode')); ?></td>
                            <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountName')); ?></td>
                            <td class="width1-6" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $amountDebit)); ?>
                            </td>
                            <td class="width1-7" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $amountCredit)); ?>
                            </td>
                        </tr>

                        <?php $totalDebit += $amountDebit; ?>
                        <?php $totalCredit += $amountCredit; ?>

                    <?php endforeach; ?>
                <?php endif; ?>
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
    </div>
    
    <?php if ($model->status !== 'CANCELLED!!!'): ?>
        <div>
            <?php echo CHtml::submitButton('Processing Journal', array('name' => 'Process', 'confirm' => 'Are you sure you want to process into journal transactions?')); ?>
        </div>
    <?php endif; ?>
</div>

<?php echo IdempotentManager::generate(); ?>

<?php echo CHtml::endForm(); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'cancel-message-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Cancel Message',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => false,
    ),
));?>
<div>
    <?php $hasFlash = Yii::app()->user->hasFlash('message'); ?>
    <?php if ($hasFlash): ?>
        <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('message'); ?>
        </div>
    <?php endif; ?>
</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>
    $(document).ready(function() {
        var hasFlash = <?php echo $hasFlash ? 'true' : 'false' ?>;
        if (hasFlash) {
            $("#cancel-message-dialog").dialog({modal: 'false'});
        }
    });
    
    var label = $('#status');
    var text = label.text();
    //console.log(label.text());
    if (label.val() === "PAID") {
        label.css("background-color", "green");
    }
</script>