<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 8% }
    .width1-2 { width: 8% }
    .width1-3 { width: 8% }
    .width1-4 { width: 7% }
    .width1-5 { width: 7% }
    .width1-6 { width: 7% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
    .width1-10 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <?php $supplier = Supplier::model()->findByPk($supplierId); ?>
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Laporan Transaksi Pembelian <?php echo CHtml::encode(CHtml::value($supplier, 'name')); ?></div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<div class="tab reportTab">
    <div class="tabHead"><span style="float: right"><?php //echo ReportHelper::summaryText($dataProvider); ?></span></div>
    
    <br /><br />
    
    <div class="tabBody">
        <table class="report">
            <thead style="position: sticky; top: 0">
                <tr id="header1">
                    <th class="width1-1">PO #</th>
                    <th class="width1-2">Penerimaan #</th>
                    <th class="width1-3">Invoice #</th>
                    <th class="width1-4">Tanggal</th>
                    <th class="width1-5">Type</th>
                    <th class="width1-6">Payment</th>
                    <th class="width1-7">Status</th>
                    <th class="width1-8">Total</th>
                    <th class="width1-9">Payment</th>
                    <th class="width1-10">Remaining</th>
                </tr>
            </thead>
            <tbody>
                <?php $grandTotal = '0.00'; ?>
                <?php $totalPayment = '0.00'; ?>
                <?php $totalRemaining = '0.00'; ?>
                <?php foreach ($purchaseOrders as $purchaseOrder): ?>
                    <?php $totalPrice = CHtml::value($purchaseOrder, 'invoice_grand_total'); ?>
                    <?php $paymentAmount = CHtml::value($purchaseOrder, 'invoice_payment_amount'); ?>
                    <?php $paymentRemaining = CHtml::value($purchaseOrder, 'invoice_payment_remaining'); ?>
                    <tr class="items1">
                        <td><?php echo CHtml::encode(CHtml::value($purchaseOrder, 'purchaseOrder.purchase_order_no')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($purchaseOrder, 'receive_item_no')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($purchaseOrder, 'invoice_number')); ?></td>
                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($purchaseOrder->invoice_date))); ?></td>
                        <td><?php echo CHtml::encode($purchaseOrder->purchaseOrder->getPurchaseStatus($purchaseOrder->purchaseOrder->purchase_type)); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($purchaseOrder, 'purchaseOrder.payment_status')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($purchaseOrder, 'purchaseOrder.status_document')); ?></td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPrice)); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentAmount)); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $paymentRemaining)); ?>
                        </td>
                    </tr>
                    <?php $grandTotal += $totalPrice; ?>
                    <?php $totalPayment += $paymentAmount; ?>
                    <?php $totalRemaining += $paymentRemaining; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" style="text-align: right; font-weight: bold">TOTAL</td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotal)); ?>
                    </td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPayment)); ?>
                    </td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalRemaining)); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>