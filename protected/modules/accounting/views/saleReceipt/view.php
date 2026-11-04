<?php
$this->breadcrumbs = array(
    'Tanda Terima Penjualan' => array('index'),
    $model->id,
);
?>

<?php echo CHtml::beginForm(); ?>
<div id="maincontent">
    <div class="clearfix page-action">
        
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <?php echo CHtml::link('<span class="fa fa-th-list"></span>Manage', Yii::app()->baseUrl . '/accounting/saleReceipt/admin', array(
            'class' => 'button cbutton right', 
            'style' => 'margin-right:10px',
        )) ?>
        
        <?php if ($model->status !== 'CANCELLED!!!' && Yii::app()->user->checkAccess("paymentInEdit")): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl.'/accounting/saleReceipt/update?id=' . $model->id, array(
                'class'=>'button warning right',
                'style'=>'margin-right:10px',
            )) ?>
        <?php endif; ?>
        
        <?php if ($model->status !== 'Cancelled' && Yii::app()->user->checkAccess("paymentInEdit")): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Print', Yii::app()->baseUrl.'/accounting/saleReceipt/pdf?id=' . $model->id, array(
                'class'=>'button success right',
                'style'=>'margin-right:10px',
                'target' => '_blank',
            )); ?>
        <?php endif; ?>
        
        <?php if (Yii::app()->user->checkAccess("paymentHead") && $model->status === 'Approved'): ?>
            <?php echo CHtml::link('<span class="fa fa-minus"></span>Cancel Transaction', array("/accounting/saleReceipt/cancel", "id" => $model->id), array(
                'class' => 'button alert right', 
                'style' => 'margin-right:10px', 
            )); ?>
        <?php endif; ?>
        
        <h1>View Rekap Tagihan #<?php echo $model->id; ?></h1>
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
                                    <span class="prefix">Rekap #</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->transaction_number; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Tanggal</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo Yii::app()->dateFormatter->format("d MMM yyyy", strtotime($model->transaction_date)); ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Jatuh Tempo</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo Yii::app()->dateFormatter->format("d MMM yyyy", strtotime($model->due_date)); ?>"> 
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($model->customer_id)): ?>
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Customer</span>
                                    </div>

                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" value="<?php echo CHtml::encode(CHtml::value($model, 'customer.name')); ?>"> 
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Customer Type</span>
                                    </div>

                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" id="Customer_customer_type" value="<?php echo CHtml::encode(CHtml::value($model, 'customer.customer_type')); ?>"> 
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Asuransi</span>
                                    </div>

                                    <div class="small-8 columns">
                                        <input type="text" readonly="true" value="<?php echo CHtml::encode(CHtml::value($model, 'insuranceCompany.name')); ?>"> 
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (Yii::app()->user->checkAccess("director")): ?>
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">User Created</span>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(CHtml::value($model, 'userIdCreated.username')); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Date Created</span>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy hh:M:s", strtotime(CHtml::value($model, 'created_datetime')))); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>       
                    </div>

                    <div class="large-6 columns">
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
                                    <span class="prefix">Resi Kirim #</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->delivery_receipt_number; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Note</span>
                                </div>
                                
                                <div class="small-8 columns">
                                    <textarea name="" id="" cols="30" rows="4" readonly="true"><?php echo $model->note; ?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <?php if (Yii::app()->user->checkAccess("director")): ?>
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">User Edited</span>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(CHtml::value($model, 'userIdUpdated.username')); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Date Edited</span>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php echo $model->updated_datetime === null ? '' : CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy hh:M:s", strtotime(CHtml::value($model, 'updated_datetime')))); ?>
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
                                        <?php echo $model->cancelled_datetime === null ? '' : CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy hh:M:s", strtotime(CHtml::value($model, 'cancelled_datetime')))); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>                        
                    </div>
                </div>
            </fieldset>
            
            <fieldset>
                <legend>Transaksi Detail</legend>
                <div id="invoice-detail">
                    <table>
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Tanggal</th>
                                <th>Jatuh Tempo</th>
                                <th>Plate #</th>
                                <th>Kendaraan</th>
                                <th>SPK #</th>
                                <th>Jasa</th>
                                <th>Parts</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($model->saleReceiptDetails as $detail): ?>
                                <tr>
                                    <td>
                                        <?php echo CHtml::link($detail->invoiceHeader->invoice_number, array(
                                            "/transaction/invoiceHeader/show", 
                                            "id" => $detail->invoice_header_id
                                        ), array('target' => 'blank')); ?>
                                    </td>
                                    <td>
                                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", strtotime(CHtml::value($detail, 'invoiceHeader.invoice_date')))); ?>
                                    </td>
                                    <td>
                                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", strtotime(CHtml::value($detail, 'invoiceHeader.due_date')))); ?>
                                    </td>
                                    <td><?php echo CHtml::encode(CHtml::value($detail, 'invoiceHeader.vehicle.plate_number')); ?></td>
                                    <td>
                                        <?php echo CHtml::encode(CHtml::value($detail, "invoiceHeader.vehicle.carMake.name")); ?> -
                                        <?php echo CHtml::encode(CHtml::value($detail, "invoiceHeader.vehicle.carModel.name")); ?> -
                                        <?php echo CHtml::encode(CHtml::value($detail, "invoiceHeader.vehicle.carSubModel.name")); ?>
                                    </td>
                                    <td>
                                        <?php echo CHtml::link($detail->invoiceHeader->registrationTransaction->customer_work_order_number, array(
                                            "/frontDesk/registrationTransaction/view", 
                                            "id" => $detail->invoiceHeader->registration_transaction_id
                                        ), array('target' => 'blank')); ?>
                                    </td>
                                    <td style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'invoiceHeader.service_price'))); ?>
                                    </td>
                                    <td style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'invoiceHeader.product_price'))); ?>
                                    </td>
                                    <td style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'invoice_amount'))); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="text-align: right; font-weight: bold" colspan="6">Sub Total</td>
                                <td style="text-align: right; font-weight: bold">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, 'totalServiceAmount'))); ?>
                                </td>
                                <td style="text-align: right; font-weight: bold">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, 'totalPartsAmount'))); ?>
                                </td>
                                <td style="text-align: right; font-weight: bold">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, 'total_invoice_amount'))); ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" style="text-align: right; font-weight: bold">
                                    PPn <?php echo CHtml::encode(CHtml::value($model, "tax_item_percentage")); ?>%
                                </td>
                                <td style="text-align: right; font-weight: bold">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, 'tax_item_amount'))); ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" style="text-align: right; font-weight: bold">
                                    PPh 23 <?php echo CHtml::encode(CHtml::value($model, "tax_service_percentage")); ?>%
                                </td>
                                <td style="text-align: right; font-weight: bold">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, 'tax_service_amount'))); ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" style="text-align: right; font-weight: bold">Grand Total</td>
                                <td style="text-align: right; font-weight: bold">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, "total_receivable_amount"))); ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </fieldset>
        </div>
    </div>
</div>
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
</script>