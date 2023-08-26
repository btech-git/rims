<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 20% }
    .width1-2 { width: 25% }
    .width1-3 { width: 25% }

    .width2-1 { width: 15% }
    .width2-2 { width: 15% }
    .width2-3 { width: 15% }
    .width2-4 { width: 15% }
    .width2-5 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Rincian Pembelian per Pemasok</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead>
        <tr id="header1">
                <th class="width1-1">Code</th>
                <th class="width1-2">Company</th>
                <th class="width1-3">Name</th>
        </tr>
        <tr id="header2">
            <td colspan="3">
                <table>
                    <tr>
                        <th class="width2-1">Pembelian #</th>
                        <th class="width2-2">Tanggal</th>
                        <th class="width2-3">Payment</th>
                        <th class="width2-4">Status</th>
                        <th class="width2-5">Total Price</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($purchaseReport as $purchaseItem): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode($purchaseItem['code']); ?></td>
                <td class="width1-2"><?php echo CHtml::encode($purchaseItem['company']); ?></td>
                <td class="width1-3"><?php echo CHtml::encode($purchaseItem['name']); ?></td>
            </tr>

            <tr class="items2">
                <td colspan="3">
                    <table>
                        <?php $totalPurchase = 0.00; ?>
                        <?php $purchaseOrders = TransactionPurchaseOrder::model()->findAll(array(
                            'condition' => 'supplier_id = :supplier_id AND purchase_order_date BETWEEN :start_date AND :end_date', 
                            'params' => array(
                                ':supplier_id' => $purchaseItem['id'],
                                ':start_date' => $startDate,
                                ':end_date' => $endDate,
                            )
                        )); ?>
                        <?php if (!empty($purchaseOrders)): ?>
                            <?php foreach ($purchaseOrders as $detail): ?>
                                <?php $grandTotal = CHtml::value($detail, 'total_price'); ?>
                                <tr>
                                    <td class="width2-1"><?php echo CHtml::link(CHtml::encode($detail->purchase_order_no), array("/transaction/transactionPurchaseOrder/view", "id"=>$detail->id), array("target" => "_blank")); ?></td>
                                    <td class="width2-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->purchase_order_date))); ?></td>
                                    <td class="width2-3"><?php echo CHtml::encode(CHtml::value($detail, 'payment_type')); ?></td>
                                    <td class="width2-4"><?php echo CHtml::encode(CHtml::value($detail, 'payment_status')); ?></td>
                                    <td class="width2-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?></td>
                                </tr>
                                <?php $totalPurchase += $grandTotal; ?>
                            <?php endforeach; ?>
                            <tr>
                                <td style="text-align: right; font-weight: bold" colspan="4">Total</td>
                                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPurchase)); ?></td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>