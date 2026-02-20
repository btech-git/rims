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
    .width2-6 { width: 15% }
    .width2-7 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Rincian Pembelian per Supplier</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
                <th class="width1-1">Code</th>
                <th class="width1-2">Company</th>
                <th class="width1-3">Name</th>
        </tr>
        <tr id="header2">
            <td colspan="3">
                <table>
                    <tr>
                        <th class="width2-1">Transaction #</th>
                        <th class="width2-2">Tanggal</th>
                        <th class="width2-3">Kredit/Cash</th>
                        <th class="width1-4">Type</th>
                        <th class="width1-5">Parts</th>
                        <th class="width2-6">Status</th>
                        <th class="width2-7">Total Price</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    
    <tbody>
        <?php $grandTotalPurchase = 0.00; ?>
        <?php foreach ($purchasePerSupplierSummary->dataProvider->data as $header): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'code')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'company')); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
            </tr>

            <tr class="items2">
                <td colspan="3">
                    <table>
                        <?php $totalPurchase = 0.00; ?>
                        <?php $totalWorkOrderExpense = 0.00; ?>
                        <?php $purchaseOrderData = $header->getPurchasePerSupplierReport($startDate, $endDate, $branchId); ?>
                        <?php $workOrderExpenseData = $header->getWorkOrderExpensePerSupplierReport($startDate, $endDate, $branchId); ?>
                        
                        <?php if (!empty($purchaseOrderData)): ?>
                            <?php foreach ($purchaseOrderData as $purchaseOrderItem): ?>
                                <?php $totalPrice = $purchaseOrderItem['total_price']; ?>
                                <?php $purchaseOrder = TransactionPurchaseOrder::model()->findByPk($purchaseOrderItem['id']); ?>
                                <tr>
                                    <td class="width2-1">
                                        <?php echo CHtml::link($purchaseOrderItem['purchase_order_no'], Yii::app()->createUrl("transaction/transactionPurchaseOrder/view", array("id" => $purchaseOrderItem['id'])), array('target' => '_blank')); ?>
                                    </td>
                                    <td class="width2-2">
                                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($purchaseOrderItem['purchase_order_date']))); ?>
                                    </td>
                                    <td class="width2-3"><?php echo CHtml::encode($purchaseOrderItem['payment_type']); ?></td>
                                    <td class="width2-4"><?php echo CHtml::encode($purchaseOrder->getPurchaseStatus($purchaseOrder->purchase_type)); ?></td>
                                    <td class="width2-5"><?php echo CHtml::encode($purchaseOrder->getProductLists()); ?></td>
                                    <td class="width2-6"><?php echo CHtml::encode($purchaseOrderItem['payment_status']); ?></td>
                                    <td class="width2-7" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPrice)); ?>
                                    </td>
                                </tr>
                                <?php $totalPurchase += $totalPrice; ?>
                            <?php endforeach; ?>
                            <tr>
                                <td style="text-align: right; font-weight: bold" colspan="6">Total</td>
                                <td style="text-align: right; font-weight: bold">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPurchase)); ?>
                                </td>
                            </tr>
                            <?php $grandTotalPurchase += $totalPurchase; ?>
                        <?php endif; ?>
                            
                        <?php if (!empty($workOrderExpenseData)): ?>
                            <?php foreach ($workOrderExpenseData as $workOrderExpenseItem): ?>
                                <?php $totalPrice = $workOrderExpenseItem['grand_total']; ?>
                                <tr>
                                    <td class="width2-1">
                                        <?php echo CHtml::link($workOrderExpenseItem['transaction_number'], Yii::app()->createUrl("accounting/workOrderExpense/view", array("id" => $workOrderExpenseItem['id'])), array('target' => '_blank')); ?>
                                    </td>
                                    <td class="width2-2">
                                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($workOrderExpenseItem['transaction_date']))); ?>
                                    </td>
                                    <td class="width2-3"><?php echo CHtml::encode($workOrderExpenseItem['registration_number']); ?></td>
                                    <td class="width2-2">
                                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($workOrderExpenseItem['registration_date']))); ?>
                                    </td>
                                    <td class="width2-4"><?php echo CHtml::encode($workOrderExpenseItem['plate_number']); ?></td>
                                    <td class="width2-4"><?php echo CHtml::encode($workOrderExpenseItem['status']); ?></td>
                                    <td class="width2-5" style="text-align: right">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPrice)); ?>
                                    </td>
                                </tr>
                                <?php $totalWorkOrderExpense += $totalPrice; ?>
                            <?php endforeach; ?>
                            <tr>
                                <td style="text-align: right; font-weight: bold" colspan="6">Total</td>
                                <td style="text-align: right; font-weight: bold">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalWorkOrderExpense)); ?>
                                </td>
                            </tr>
                            <?php $grandTotalPurchase += $totalPurchase; ?>
                        <?php endif; ?>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right; font-weight: bold" colspan="2">TOTAL PEMBELIAN</td>
            <td style="text-align: right; font-weight: bold" class="width1-3">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotalPurchase)); ?>
            </td>
        </tr>
    </tfoot>
</table>