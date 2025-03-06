<?php
/* @var $this TransactionReceiveItemController */
/* @var $model TransactionReceiveItem */

$this->breadcrumbs = array(
    'Transaction Delivery Orders' => array('admin'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List TransactionDeliveryOrder', 'url' => array('index')),
    array('label' => 'Create TransactionDeliveryOrder', 'url' => array('create')),
    array('label' => 'Update TransactionDeliveryOrder', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete TransactionDeliveryOrder', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage TransactionDeliveryOrder', 'url' => array('admin')),
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Delivery Order', Yii::app()->baseUrl . '/transaction/transactionDeliveryOrder/admin', array('class' => 'button cbutton right', 'visible' => Yii::app()->user->checkAccess("transaction.transactionDeliveryOrder.admin"))) ?>

        <?php if ($model->is_cancelled == 0): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl . '/transaction/transactionDeliveryOrder/update?id=' . $model->id, array(
                'class' => 'button cbutton right', 
                'style' => 'margin-right:10px', 
                'visible' => Yii::app()->user->checkAccess("deliveryEdit")
            )); ?>
            <?php echo CHtml::link('<span class="fa fa-print"></span>Print Surat Jalan', array("pdf", "id" => $model->id), array(
                'class' => 'button warning right', 
                'style' => 'margin-right:10px', 
                'target' => 'blank'
            )) ?>
        <?php endif; ?>

        <h1>View Transaction Delivery Order #<?php echo $model->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'delivery_order_no',
                'delivery_date',
                'posting_date',
                array(
                    'name' => 'sender_id',
                    'header' => 'Sender',
                    'value' => $model->sender->username
                ),
                array(
                    'name' => 'sender_branch_id',
                    'header' => 'Sender Branch',
                    'value' => $model->senderBranch->name
                ),
                'request_type',
                'request_date',
                array(
                    'name' => 'destination_branch_id',
                    'header' => 'Destination Branch',
                    'value' => empty($model->destinationBranch) ? '' : $model->destinationBranch->name
                ),
                array(
                    'name' => 'customer_id',
                    'header' => 'Customer',
                    'value' => empty($model->customer) ? 'N/A' : $model->customer->name
                ),
            ),
        )); ?>
    </div>
</div>

<?php if ($model->is_cancelled == 1): ?>
    <div class="detail">
        <hr />

        <h3>Transaction Cancelled!!!</h3>
        <div class="row">
            <div class="small-12 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="label">User Cancel</label>
                        </div>

                        <div class="small-8 columns">
                            <label for="label"><?php echo empty($model->user_id_cancelled) ? '' : $model->userIdCancelled->username; ?></label>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="label">Cancel Date</label>
                        </div>

                        <div class="small-8 columns">
                            <label for="label"><?php echo empty($model->cancelled_datetime) ? '' : $model->cancelled_datetime; ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="detail">
        <hr />

        <h3>Details</h3>

        <?php if ($model->request_type == 'Sales Order'): ?>
            <div class="row">
                <div class="small-12 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label for="label">SO no</label>
                            </div>

                            <div class="small-8 columns">
                                <label for="label"><?php echo $model->salesOrder != "" ? CHTml::link($model->salesOrder->sale_order_no, array("/transaction/transactionSalesOrder/show", "id" => $model->sales_order_id), array('target' => 'blank')) : ''; ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label for="label">Customer</label>
                            </div>

                            <div class="small-8 columns">
                                <label for="label"><?php echo $model->customer_id == NULL ? '-' : $model->customer->name; ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif ($model->request_type == 'Sent Request'): ?>
            <div class="row">
                <div class="small-12 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label for="label">Sent Request no</label>
                            </div>

                            <div class="small-8 columns">
                                <label for="label"><?php echo $model->sentRequest != NULL ? CHTml::link($model->sentRequest->sent_request_no, array("/transaction/transactionSentRequest/show", "id" => $model->sent_request_id), array('target' => 'blank')) : ''; ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label for="label">Destination Branch</label>
                            </div>

                            <div class="small-8 columns">
                                <label for="label"><?php echo $model->destination_branch == NULL ? '-' : $model->destinationBranch->name; ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif ($model->request_type == 'Consignment Out') : ?>
            <div class="row">
                <div class="small-12 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label for="label">Consignment Out</label>
                            </div>

                            <div class="small-8 columns">
                                <label for="label"><?php echo $model->consignmentOut != NULL ? CHTml::link($model->consignmentOut->consignment_out_no, array("/transaction/consignmentOut/show", "id" => $model->consignment_out_id), array('target' => 'blank')) : ''; ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label for="label">Customer</label>
                            </div>

                            <div class="small-8 columns">
                                <label for="label"><?php echo $model->customer_id == NULL ? '-' : $model->customer->name; ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif ($model->request_type == 'Transfer Request') : ?>
            <div class="row">
                <div class="small-12 columns">
                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label for="label">Transfer Request</label>
                            </div>

                            <div class="small-8 columns">
                                <label for="label"><?php echo $model->transferRequest != NULL ? CHTml::link($model->transferRequest->transfer_request_no, array("/transaction/transferRequest/show", "id" => $model->transfer_request_id), array('target' => 'blank')) : ''; ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="row collapse">
                            <div class="small-4 columns">
                                <label for="label">Destination Branch</label>
                            </div>

                            <div class="small-8 columns">
                                <label for="label"><?php echo $model->destination_branch == NULL ? '-' : $model->destinationBranch->name; ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <br /><br />

        <?php if (count($deliveryDetails) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <td>Code</td>
                        <td>Kategori</td>
                        <td>Brand</td>
                        <td>Sub Brand</td>
                        <td>Sub Brand Series</td>
                        <th>Quantity</th>
                        <th>QTY Delivery</th>
                        <th>QTY Left</th>
                        <th>QTY Movement</th>
                        <th>QTY Movement Left</th>
                        <th>Note</th>
                        <!--<th>Barcode Product</th>-->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($deliveryDetails as $key => $deliveryDetail): ?>
                        <tr>
                            <td><?php echo $deliveryDetail->product->name == '' ? '-' : $deliveryDetail->product->name; ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($deliveryDetail, 'product.manufacturer_code')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($deliveryDetail, 'product.masterSubCategoryCode')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($deliveryDetail, 'product.brand.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($deliveryDetail, 'product.subBrand.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($deliveryDetail, 'product.subBrandSeries.name')); ?></td>
                            <td><?php echo $deliveryDetail->quantity_request == '' ? '-' : $deliveryDetail->quantity_request; ?></td>
                            <td><?php echo $deliveryDetail->quantity_delivery == '' ? '-' : $deliveryDetail->quantity_delivery; ?></td>
                            <td><?php echo $deliveryDetail->quantity_request_left == '' ? '-' : $deliveryDetail->quantity_request_left; ?></td>
                            <td><?php echo $deliveryDetail->quantity_movement == '' ? '-' : $deliveryDetail->quantity_movement; ?></td>
                            <td><?php echo $deliveryDetail->quantity_movement_left == '' ? '-' : $deliveryDetail->quantity_movement_left; ?></td>
                            <td><?php echo $deliveryDetail->note == '' ? '-' : $deliveryDetail->note; ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>	
        <?php else: ?>
            <?php echo 'No Details Available'; ?>
        <?php endif; ?>

        <br />

        <?php if (Yii::app()->user->checkAccess("generalManager")): ?>
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
                        <?php $transactions = JurnalUmum::model()->findAllByAttributes(array('kode_transaksi' => $model->delivery_order_no, 'is_coa_category' => 0)); ?>
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

        <br />

        <hr />

        <?php
        if ($model->request_type == 'Sales Order') {
            $itemHeaders = TransactionDeliveryOrder::model()->findAllByAttributes(array('sales_order_id' => $model->sales_order_id));
        } elseif ($model->request_type == 'Sent Request') {
        ?>

        <?php $itemHeaders = TransactionDeliveryOrder::model()->findAllByAttributes(array('sent_request_id' => $model->sent_request_id)); ?>
        <?php } else $itemHeaders = array(); ?>

        <?php if (count($itemHeaders) != 0): ?>
            <table>
                <caption>History</caption>
                <thead>
                    <tr>
                        <td>Request No</td>
                        <td>Product</td>
                        <td>Qty Request</td>
                        <td>Qty Delivery</td>
                        <td>Qty Request Left</td>
                        <td>Note</td>
                        <td>Barcode</td>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($itemHeaders as $key => $itemHeader): ?>
                        <?php $deliveryDetails = TransactionDeliveryOrderDetail::model()->findAllByAttributes(array('delivery_order_id' => $itemHeader->id)); ?>
                        <?php foreach ($deliveryDetails as $key => $deliveryDetail): ?>
                            <tr>
                                <td><?php echo $deliveryDetail->deliveryOrder->delivery_order_no; ?></td>
                                <td><?php echo $deliveryDetail->product->name; ?></td>
                                <td><?php echo $deliveryDetail->quantity_request; ?></td>
                                <td><?php echo $deliveryDetail->quantity_delivery; ?></td>
                                <td><?php echo $deliveryDetail->quantity_request_left; ?></td>
                                <td><?php echo $deliveryDetail->note; ?></td>
                                <td><?php echo $deliveryDetail->barcode_product; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
<?php endif; ?>

<hr />
    
<div>
    <h3>Movement Out</h3>
    <?php foreach ($model->movementOutHeaders as $movementOutHeader): ?>
        <div class="row">
            <div class="small-12 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="label">Movement Out no</label>
                        </div>
                        
                        <div class="small-8 columns">
                            <label for="label"><?php echo CHtml::encode(CHtml::value($movementOutHeader, 'movement_out_no')); ?></label>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="label">Tanggal</label>
                        </div>
                        
                        <div class="small-8 columns">
                            <label for="label"><?php echo CHtml::encode(CHtml::value($movementOutHeader, 'date_posting')); ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br /><br />
        
        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Product</th>
                    <th>Brand</th>
                    <th>Sub Brand</th>
                    <th>Sub Brand Series</th>
                    <th>Master Category</th>
                    <th>Sub Master Category</th>
                    <th>Sub Category</th>
                    <th>Quantity</th>
                    <th>QTY Transaction</th>
                    <th>Gudang</th>
                </tr>
            </thead>
            
            <tbody>
                <?php foreach ($movementOutHeader->movementOutDetails as $movementOutDetail): ?>
                    <tr>
                        <?php $product = empty($movementOutDetail->product) ? '' : $movementOutDetail->product; ?>
                        <td><?php echo $product->manufacturer_code; ?></td>
                        <td><?php echo $product->name; ?></td>
                        <td><?php echo $product->brand->name; ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?></td>
                        <td><?php echo $product->productMasterCategory->name; ?></td>
                        <td><?php echo $product->productSubMasterCategory->name; ?></td>
                        <td><?php echo $product->productSubCategory->name; ?></td>
                        <td><?php echo $movementOutDetail->quantity; ?></td>
                        <td><?php echo $movementOutDetail->quantity_transaction; ?></td>
                        <td><?php echo empty($movementOutDetail->warehouse) ? '' : $movementOutDetail->warehouse->name; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
</div>

<br />

<div class="field buttons text-center">
    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::submitButton('Processing Journal', array('name' => 'Process', 'confirm' => 'Are you sure you want to process into journal transactions?')); ?>
    <?php echo CHtml::endForm(); ?>
</div>

<div>
    <?php if (Yii::app()->user->checkAccess("saleInvoiceSupervisor")): ?>
        <?php echo CHtml::link('<span class="fa fa-minus"></span>Cancel Transaction', array("/transaction/transactionDeliveryOrder/cancel", "id" => $model->id), array(
            'class' => 'button alert right', 
            'style' => 'margin-right:10px', 
        )); ?>
    <?php endif; ?>
</div>

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