<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 8% }
    .width1-2 { width: 5% }
    .width1-3 { width: 15% }
    .width1-4 { width: 5% }
    .width1-5 { width: 15% }
    .width1-6 { width: 8% }
    .width1-7 { width: 5% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
    .width1-10 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Laporan Transaksi Pembelian</div>
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
                    <th class="width1-2">Tanggal</th>
                    <th class="width1-3">Supplier</th>
                    <th class="width1-4">Type</th>
                    <th class="width1-5">Payment</th>
                    <th class="width1-6">Status</th>
                    <th class="width1-7">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $grandTotal = '0.00'; ?>
                <?php foreach ($purchaseOrders as $purchaseOrder): ?>
                    <?php $totalPrice = CHtml::value($purchaseOrder, 'total_price'); ?>
                    <tr class="items1">
                        <td class="width1-1"><?php echo CHtml::encode(CHtml::value($purchaseOrder, 'purchase_order_no')); ?></td>
                        <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($purchaseOrder->purchase_order_date))); ?></td>
                        <td class="width1-3"><?php echo CHtml::encode(CHtml::value($purchaseOrder, 'supplier.name')); ?></td>
                        <td class="width1-4"><?php echo CHtml::encode($purchaseOrder->getPurchaseStatus($purchaseOrder->purchase_type)); ?></td>
                        <td class="width1-5"><?php echo CHtml::encode(CHtml::value($purchaseOrder, 'payment_status')); ?></td>
                        <td class="width1-6"><?php echo CHtml::encode(CHtml::value($purchaseOrder, 'status_document')); ?></td>
                        <td class="width1-7" style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPrice)); ?>
                        </td>
                    </tr>
                    <?php $grandTotal += $totalPrice; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" style="text-align: right; font-weight: bold">TOTAL</td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $grandTotal)); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>