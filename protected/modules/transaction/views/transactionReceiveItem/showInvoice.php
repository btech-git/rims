<?php
/* @var $this TransactionReceiveItemController */
/* @var $model TransactionReceiveItem */

$this->breadcrumbs = array(
    'Invoice' => array('admin'),
    $receiveHeader->id,
);
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <h1>View Supplier Invoice #<?php echo $receiveHeader->invoice_number; ?></h1>
        
        <table>
            <tr>
                <td width="15%">Invoice #</td>
                <td><?php echo $receiveHeader->invoice_number; ?></td>
            </tr>
            <tr>
                <td width="15%">Tanggal</td>
                <td><?php echo Yii::app()->dateFormatter->format("d MMMM yyyy", $receiveHeader->invoice_date); ?></td>
            </tr>
            <tr>
                <td width="15%">Faktur Pajak #</td>
                <td><?php echo $receiveHeader->invoice_tax_number; ?></td>
            </tr>
            <tr>
                <td width="15%">Jatuh Tempo</td>
                <td><?php echo Yii::app()->dateFormatter->format("d MMMM yyyy", $receiveHeader->invoice_due_date); ?></td>
            </tr>
            <tr>
                <td width="15%">Receive Item No</td>
                <td><?php echo CHtml::link($receiveHeader->receive_item_no, array("/transaction/transactionReceiveItem/show", "id"=>$receiveHeader->id), array('target' => 'blank')); ?></td>
            </tr>
            <tr>
                <td width="15%">Tanggal</td>
                <td><?php echo Yii::app()->dateFormatter->format("d MMMM yyyy", $receiveHeader->receive_item_date); ?></td>
            </tr>
            <tr>
                <td width="15%">Supplier SJ#</td>
                <td><?php echo $receiveHeader->supplier_delivery_number; ?></td>
            </tr>
            <tr>
                <td width="15%">Status</td>
                <td><?php echo CHtml::encode(CHtml::value($receiveHeader, 'approvalStatus')); ?></td>
            </tr>
            <tr>
                <td width="15%">Approved by</td>
                <td><?php echo CHtml::encode(CHtml::value($receiveHeader, 'userIdApprovalInvoice.username')); ?></td>
            </tr>
            <tr>
                <td width="15%">Approval Date</td>
                <td><?php echo Yii::app()->dateFormatter->format("d MMMM yyyy", $receiveHeader->date_approval_invoice); ?></td>
            </tr>
            <tr>
                <td width="15%">Approval Time</td>
                <td><?php echo Yii::app()->dateFormatter->format("H:i:s", $receiveHeader->time_approval_invoice); ?></td>
            </tr>
            <tr>
                <td colspan="2">
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
                                <td>Qty Order</td>
                                <td>Qty Received</td>
                                <td>Unit</td>
                                <td>Price</td>
                                <td>Total</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($receiveHeader->transactionReceiveItemDetails as $key => $receiveDetail): ?>
                                <tr>
                                    <?php $product = $receiveDetail->product; ?>
                                    <td><?php echo CHtml::encode(CHtml::value($product, 'id')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($product, 'name')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($product, 'masterSubCategoryCode')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?></td>
                                    <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($receiveDetail, 'qty_request')); ?></td>
                                    <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($receiveDetail, 'qty_received')); ?></td>
                                    <td><?php echo CHtml::encode(CHtml::value($product, 'unit.name')); ?></td>
                                    <td style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveDetail, 'purchaseOrderDetail.unit_price'))); ?>
                                    </td>
                                    <td style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveDetail, 'totalPrice'))); ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="11" style="text-align: right">SUB TOTAL</td>
                                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveHeader, 'invoice_sub_total'))); ?></td>
                            </tr>
                            <tr>
                                <td colspan="11" style="text-align: right">PPn <?php echo CHtml::encode(CHtml::value($receiveHeader, 'purchaseOrder.tax_percentage'));?>%</td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveHeader, 'invoice_tax_nominal'))); ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="11" style="text-align: right">GRAND TOTAL</td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveHeader, 'invoice_grand_total'))); ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>

<div>
    <?php $paymentOutDetails = PayOutDetail::model()->findAllByAttributes(array('receive_item_id' => $receiveHeader->id)); ?>
    
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
</div>