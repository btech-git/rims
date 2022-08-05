<?php
/* @var $this TransactionReceiveItemController */
/* @var $model TransactionReceiveItem */

$this->breadcrumbs = array(
    'Transaction Transfer Requests' => array('admin'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List TransactionReceiveItem', 'url' => array('index')),
    array('label' => 'Create TransactionReceiveItem', 'url' => array('create')),
    array('label' => 'Update TransactionReceiveItem', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete TransactionReceiveItem', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage TransactionReceiveItem', 'url' => array('admin')),
);
?>



<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Receive Item', Yii::app()->baseUrl . '/transaction/transactionReceiveItem/admin', array('class' => 'button cbutton right', 'visible' => Yii::app()->user->checkAccess("transaction.transactionReceiveItem.admin"))) ?>

        <?php
        $movements = MovementInHeader::model()->findAllByAttributes(array('receive_item_id' => $model->id));
        if (count($movements)== 0 && $model->request_type != 'Retail Sales'):
        ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl . '/transaction/transactionReceiveItem/update?id=' . $model->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("transaction.transactionReceiveItem.update"))) ?>
        <?php endif; ?>

        <?php if (empty($model->invoice_number) && !empty($model->purchase_order_id)): ?>
            <?php echo CHtml::link('<span class="fa fa-plus"></span>Add Supporting Docs', Yii::app()->baseUrl . '/transaction/transactionReceiveItem/addInvoice?id=' . $model->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("transaction.transactionReceiveItem.update"))) ?>
        <?php endif; ?>

        <h1>View Transaction Receive Item #<?php echo $model->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'receive_item_no',
                'receive_item_date',
                'arrival_date',
                array(
                    'name' => 'recipient_id',
                    'label' => 'Penerima',
                    'value' => $model->user->username,
                ),
                array(
                    'name' => 'recipient_branch_id',
                    'label' => 'Branch',
                    'value' => $model->recipientBranch->name,
                ),
                'request_type',
                'estimate_arrival_date',
            ),
        )); ?>
    </div>
</div>

<hr />
    
<div class="detail">
    <h3>Details</h3>
    
    <?php if ($model->request_type == 'Purchase Order'): ?>
        <div class="row">
            <div class="small-12 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="label">PO no</label>
                        </div>
                        
                        <div class="small-8 columns">
                            <label for="label"><?php echo $model->purchase_order_id == NULL ? '-' : CHTml::link($model->purchaseOrder->purchase_order_no, array("/transaction/transactionPurchaseOrder/view", "id"=>$model->purchaseOrder->id)); ?></label>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="label">PO note</label>
                        </div>
                        
                        <div class="small-8 columns">
                            <label for="label"><?php echo empty($model->purchaseOrderApprovals) ? "" : $model->purchaseOrderApprovals[0]->note; ?></label>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="label">Supplier</label>
                        </div>
                        
                        <div class="small-8 columns">
                            <label for="label"><?php echo $model->supplier_id == NULL ? '-' : $model->supplier->name; ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif ($model->request_type == 'Internal Delivery Order') : ?>
        <div class="row">
            <div class="small-12 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="label">Delivery Order no</label>
                        </div>
                        
                        <div class="small-8 columns">
                            <label for="label"><?php echo $model->delivery_order_id == NULL ? '-' : $model->deliveryOrder->delivery_order_no; ?></label>
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
    <?php elseif ($model->request_type == 'Consignment In') : ?>
        <div class="row">
            <div class="small-12 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="label">Consignment no</label>
                        </div>
                        
                        <div class="small-8 columns">
                            <label for="label"><?php echo $model->consignment_in_id == NULL ? '-' : $model->consignmentIn->consignment_in_number; ?></label>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="label">Supplier</label>
                        </div>
                        
                        <div class="small-8 columns">
                            <label for="label"><?php echo $model->supplier_id == NULL ? '-' : $model->supplier->name; ?></label>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="label">Invoice No</label>
                        </div>
                        
                        <div class="small-8 columns">
                            <label for="label"><?php echo $model->invoice_number; ?></label>
                        </div>
                    </div>
                </div>
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="label">Invoice Date</label>
                        </div>
                        
                        <div class="small-8 columns">
                            <label for="label"><?php echo $model->invoice_date; ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif ($model->request_type == 'Retail Sales') : ?>
        <div class="row">
            <div class="small-12 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <label for="label">Movement Out no</label>
                        </div>
                        
                        <div class="small-8 columns">
                            <label for="label"><?php echo $model->movement_out_id == NULL ? '-' : $model->movementOut->movement_out_no; ?></label>
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
    <?php endif ?>
    
    <br />
    
    <?php if (count($recieveDetails) > 0): ?>
        <table>
            <thead>
                <tr>
                    <td>Product</td>
                    <td>Code</td>
                    <td>Kategori</td>
                    <td>Brand</td>
                    <td>Sub Brand</td>
                    <td>Sub Brand Series</td>
                    <td>QTY Request</td>
                    <td>QTY Received</td>
                    <?php if ($model->delivery_order_id != ""): ?>
                        <td>QTY Delivered</td>
                        <td>QTY Delivered Left</td>
                    <?php endif; ?>
                    <td>QTY Movement</td>
                    <td>QTY Movement Left</td>
                    <td>QTY Request Left</td>
                    <td>Note</td>
                </tr>
            </thead>
            
            <tbody>
                <?php foreach ($recieveDetails as $key => $recieveDetail): ?>
                    <tr>
                        <td><?php echo $recieveDetail->product_id == NULL ? '-' : $recieveDetail->product->name; ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($recieveDetail, 'product.manufacturer_code')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($recieveDetail, 'product.masterSubCategoryCode')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($recieveDetail, 'product.brand.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($recieveDetail, 'product.subBrand.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($recieveDetail, 'product.subBrandSeries.name')); ?></td>
                        <td><?php echo $recieveDetail->qty_request; ?></td>
                        <td><?php echo $recieveDetail->qty_received; ?></td>
                        <?php if ($recieveDetail->delivery_order_detail_id != ""): ?>
                            <td><?php echo $recieveDetail->quantity_delivered; ?></td>
                            <td><?php echo $recieveDetail->quantity_delivered_left; ?></td>
                        <?php endif; ?>
                        <td><?php echo $recieveDetail->quantity_movement; ?></td>
                        <td><?php echo $recieveDetail->quantity_movement_left; ?></td>
                        <td><?php echo $recieveDetail->qty_request_left; ?></td>
                        <td><?php echo $recieveDetail->note == NULL ? '-' : $recieveDetail->note; ?></td>
                    </tr>
                <?php endforeach; ?>
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
                    <?php $transactions = JurnalUmum::model()->findAllByAttributes(array('kode_transaksi' => $model->receive_item_no, 'is_coa_category' => 0)); ?>
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
    <?php endif; ?>

    <br />

    <hr />
    
    <?php
    if ($model->request_type == 'Purchase Order') {
        $itemHeaders = TransactionReceiveItem::model()->findAllByAttributes(array('purchase_order_id' => $model->purchase_order_id));
    } elseif ($model->request_type == 'Transfer Request') {
        ?>
        <?php $itemHeaders = TransactionReceiveItem::model()->findAllByAttributes(array('transfer_request_id' => $model->transfer_request_id)); ?>
    <?php }else
        $itemHeaders = array(); ?>

    <?php if (count($itemHeaders) != 0): ?>
        <table>
            <caption>History</caption>
            <thead>
                <tr>
                    <td>Receive #</td>
                    <td>Date</td>
                    <td>Supplier SJ#</td>
                    <td>Code</td>
                    <td>Product</td>
                    <td>Qty Request</td>
                    <td>Qty Received</td>
                    <td>Qty Request Left</td>
                    <td>Note</td>
                    <td>Barcode</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($itemHeaders as $key => $itemHeader): ?>
                    <?php $receiveItemDetails = TransactionReceiveItemDetail::model()->findAllByAttributes(array('receive_item_id' => $itemHeader->id)); ?>
                    <?php foreach ($receiveItemDetails as $key => $receiveItemDetail): ?>
                        <tr>
                            <td><?php echo $receiveItemDetail->receiveItem->receive_item_no; ?></td>
                            <td><?php echo $receiveItemDetail->receiveItem->receive_item_date; ?></td>
                            <td><?php echo $receiveItemDetail->receiveItem->supplier_delivery_number; ?></td>
                            <td><?php echo $receiveItemDetail->product->manufacturer_code; ?></td>
                            <td><?php echo $receiveItemDetail->product->name; ?></td>
                            <td><?php echo $receiveItemDetail->qty_request; ?></td>
                            <td><?php echo $receiveItemDetail->qty_received; ?></td>
                            <td><?php echo $receiveItemDetail->qty_request_left; ?></td>
                            <td><?php echo $receiveItemDetail->note; ?></td>
                            <td><?php echo $receiveItemDetail->barcode_product; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<div>
    <?php $movementIns = MovementInHeader::model()->findAllByAttributes(array('receive_item_id' => $model->id)); ?>
    
    <?php if (!empty($movementIns)): ?>
        <table>
            <caption>Movement In</caption>
            <thead>
                <tr>
                    <td>Movement #</td>
                    <td>Date</td>
                    <td>Branch</td>
                    <td>Product</td>
                    <td>Qty</td>
                    <td>Warehouse</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($movementIns as $movementIn): ?>
                    <?php $movementInDetails = MovementInDetail::model()->findAllByAttributes(array('movement_in_header_id' => $movementIn->id)); ?>
                    <?php foreach ($movementInDetails as $movementInDetail): ?>
                        <tr>
                            <td><?php echo $movementIn->movement_in_number; ?></td>
                            <td><?php echo $movementIn->date_posting; ?></td>
                            <td><?php echo $movementIn->branch->name; ?></td>
                            <td><?php echo $movementInDetail->product->name; ?></td>
                            <td><?php echo $movementInDetail->quantity; ?></td>
                            <td><?php echo $movementInDetail->warehouse->name; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>