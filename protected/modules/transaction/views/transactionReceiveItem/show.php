<?php
/* @var $this TransactionReceiveItemController */
/* @var $model TransactionReceiveItem */

$this->breadcrumbs = array(
    'Transaction Transfer Requests' => array('admin'),
    $model->id,
);
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <h1>View Transaction Receive Item #<?php echo $model->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'receive_item_no',
                array(
                    'name' => 'receive_item_date',
                    'label' => 'Tanggal Doc Penerimaan',
                    'value' => $model->receive_item_date,
                ),
                array(
                    'name' => 'arrival_date',
                    'label' => 'Tanggal Penerimaan Barang',
                    'value' => $model->arrival_date,
                ),
                array(
                    'name' => 'recipient_id',
                    'label' => 'Penerima',
                    'value' => $model->user->username,
                ),
                array(
                    'name' => 'recipient_branch_id',
                    'label' => 'Cabang Penerima',
                    'value' => $model->recipientBranch->name,
                ),
                'request_type',
                'estimate_arrival_date',
                'note', 
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
                            <label for="label"><?php echo $model->purchase_order_id == NULL ? '-' : CHTml::link($model->purchaseOrder->purchase_order_no, array("/transaction/transactionPurchaseOrder/show", "id"=>$model->purchase_order_id)); ?></label>
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
                            <label for="label"><?php echo $model->delivery_order_id == NULL ? '-' : CHTml::link($model->deliveryOrder->delivery_order_no, array("/transaction/transactionDeliveryOrder/show", "id"=>$model->delivery_order_id)); ?></label>
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
                    <td>ID</td>
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
                        <td><?php echo $recieveDetail->product_id == NULL ? '-' : $recieveDetail->product->id; ?></td>
                        <td><?php echo $recieveDetail->product_id == NULL ? '-' : $recieveDetail->product->name; ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($recieveDetail, 'product.manufacturer_code')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($recieveDetail, 'product.masterSubCategoryCode')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($recieveDetail, 'product.brand.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($recieveDetail, 'product.subBrand.name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($recieveDetail, 'product.subBrandSeries.name')); ?></td>
                        <td><?php echo $recieveDetail->qty_request; ?></td>
                        <td><?php echo $recieveDetail->qty_received; ?></td>
                        <?php if ($model->delivery_order_id != ""): ?>
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
    
    <?php
    if ($model->request_type == 'Purchase Order' && !empty($model->purchase_order_id)) {
        $itemHeaders = TransactionReceiveItem::model()->findAllByAttributes(array('purchase_order_id' => $model->purchase_order_id));
    } elseif ($model->request_type == 'Transfer Request' && !empty($model->transfer_request_id)) {
        ?>
        <?php $itemHeaders = TransactionReceiveItem::model()->findAllByAttributes(array('transfer_request_id' => $model->transfer_request_id)); ?>
    <?php } else {
        $itemHeaders = array(); 
    } ?>


    <?php if (count($itemHeaders) > 0): ?>
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
                            <td><?php echo CHtml::link($movementIn->movement_in_number, array("/transaction/movementInHeader/show", "id"=>$movementIn->id)); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($movementIn, 'date_posting')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($movementIn, 'branch.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($movementInDetail, 'product.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($movementInDetail, 'quantity')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($movementInDetail, 'warehouse.name')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<div>
    <?php $paymentOutDetails = PayOutDetail::model()->findAllByAttributes(array('receive_item_id' => $model->id)); ?>
    
    <?php if (!empty($paymentOutDetails)): ?>
        <table>
            <caption>Payment</caption>
            <thead>
                <tr>
                    <td>Payment #</td>
                    <td>Date</td>
                    <th style="text-align: center">Memo</th>
                    <th style="text-align: center; width: 15%">Total Invoice</th>
                    <th style="text-align: center; width: 15%">Payment</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($paymentOutDetails as $paymentOutDetail): ?>
                    <tr>
                        <td><?php echo CHtml::encode(CHtml::value($paymentOutDetail, 'paymentOut.payment_number')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($paymentOutDetail, 'paymentOut.payment_date')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($paymentOutDetail, 'memo')); ?></td>
                        <td><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentOutDetail, 'total_invoice'))); ?></td>
                        <td><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentOutDetail, 'amount'))); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>