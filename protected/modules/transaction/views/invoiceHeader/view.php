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

<!--<h1>View InvoiceHeader #<?php echo $model->id; ?></h1>-->
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>

        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Invoices', Yii::app()->baseUrl . '/transaction/invoiceHeader/admin', array('class' => 'button cbutton right', 'visible' => Yii::app()->user->checkAccess("transaction.invoiceHeader.admin"))) ?>
        <?php if ($model->payment_left > 0.00): ?>
            <?php echo CHtml::link('<span class="fa fa-plus"></span>Payment', array("/transaction/paymentIn/create", "invoiceId" => $model->id), array('class' => 'button success right', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("transaction.paymentIn.create"))) ?>		
        <?php endif; ?>

        <h1>View Invoice #<?php echo $model->invoice_number; ?></h1>

        <table>
            <tr>
                <td>Invoice Number</td>
                <td><?php echo $model->invoice_number; ?></td>
                <td>Invoice Date</td>
                <td><?php echo $model->invoice_date; ?></td>
            </tr>
            
            <tr>
                <td>Reference Type</td>
                <td><?php echo $model->reference_type == 1 ? 'Sales Order' : 'Retail Sales'; ?></td>
                <td>Due Date</td>
                <td><?php echo $model->due_date; ?></td>
            </tr>
            
            <tr>
                <td>Reference Number</td>
                <td><?php if ($model->reference_type == 1): ?>
                        <?php echo $model->salesOrder->sale_order_no; ?>
                    <?php else : ?>
                        <?php echo $model->registration_transaction_id; ?>
                    <?php endif ?></td>
                <td>Branch</td>
                <td><?php echo $model->branch->name; ?></td>
            </tr>
            
            <tr>
                <td width="10%">Status</td>
                <td width="30%"><input type="text" id = "status" style="background-color:red;color:white" value="<?php echo $model->status; ?>">
                </td>
                <td width="10%">User_id</td>
                <td width="30%"><?php echo $model->user->username; ?></td>
            </tr>
            
            <tr>
                <td width="10%">Payment Bank</td>
                <td width="30%"><?php echo CHtml::encode(CHtml::value($model, 'companyBankIdEstimate.bank.name')); ?>
                </td>
                <td width="10%">Payment Est Date</td>
                <td width="30%"><?php echo $model->payment_date_estimate; ?></td>
            </tr>
            
            <tr>
                <?php $registration = RegistrationTransaction::model()->findByPk($model->registration_transaction_id); ?>
                <td width="10%">SO #</td>
                <td width="30%"><?php echo empty($registration) ? '' : CHtml::encode(CHtml::value($registration, 'sales_order_number')); ?>
                </td>
                <td width="10%">Registration #</td>
                <td width="30%"><?php echo empty($registration) ? '' :  $registration->transaction_number; ?></td>
            </tr>
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
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Price</th>
                    </thead>
                    
                    <tbody>
                        <?php foreach ($details as $i => $detail): ?>
                            <?php if ($detail->product_id != ""): ?>
                                <tr>
                                    <td><?php echo $detail->product->name; ?></td>
                                    <td><?php echo $detail->quantity; ?></td>
                                    <td><?php echo number_format($detail->unit_price, 2); ?></td>
                                    <td><?php echo number_format($detail->total_price, 2); ?></td>
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
                            <th>Service</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach ($details as $i => $detail): ?>
                            <?php if ($detail->service_id != ""): ?>
                                <tr>
                                    <td ><?php echo $detail->service->name; ?></td>
                                    <td><?php echo number_format($detail->total_price, 2); ?></td>
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
                <?php endif ?>
                <tr>
                    <td class="title">Sub Total</td>
                    <td>Rp. <?php echo number_format($model->subTotal, 2) ?></td>
                </tr>
                <tr>
                    <td class="title">PPN <?php echo CHtml::encode(CHtml::value($model, 'tax_percentage')); ?>%</td>
                    <td>Rp. <?php echo $model->ppn == 1 ? number_format($model->ppn_total, 2) : 0.00; ?></td>
                </tr>

                <?php if ($model->reference_type == 2): ?>
                    <tr>
                        <td class="title">PPH (2%) </td>
                        <td>Rp. <?php echo number_format($model->pph_total, 2) ?></td>
                    </tr>
                <?php endif ?>

                <tr>
                    <td class="title">Total Price</td>
                    <td><strong>Rp. <?php echo number_format($model->total_price, 2) ?></strong></td>
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
                                <td><?php echo $payment->payment_number; ?></td>
                                <td><?php echo $payment->payment_date; ?></td>
                                <td><?php echo $payment->paymentType->name; ?></td>
                                <td><?php echo number_format($payment->payment_amount, 2); ?></td>
                                <td><?php echo $payment->notes; ?></td>
                                <td><?php echo $payment->status; ?></td>
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
                <?php $transactions = JurnalUmum::model()->findAllByAttributes(array('kode_transaksi' => $model->invoice_number, 'is_coa_category' => 0)); ?>
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
                    <td class="width1-6" style="text-align: right; font-weight: bold; border-top: 1px solid">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalDebit)); ?>
                    </td>
                    <td class="width1-7" style="text-align: right; font-weight: bold; border-top: 1px solid">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalCredit)); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
    var label = $('#status');
    var text = label.text();
    //console.log(label.text());
    if (label.val() === "PAID") {
        label.css("background-color", "green");
    }
</script>