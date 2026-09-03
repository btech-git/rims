<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 5% }
    .width1-2 { width: 20% }
    .width1-3 { width: 20% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Pembelian per Supplier Summary</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Code</th>
            <th class="width1-2">Company</th>
            <th class="width1-3">Name</th>
            <th class="width1-4">Total Purchase</th>
            <th class="width1-5">Total Sub Pekerjaan Luar</th>
            <th class="width1-6">Pembayaran</th>
            <th class="width1-7">Sisa Hutang</th>
        </tr>
    </thead>
    
    <tbody>
        <?php $totalPurchase = '0.00'; ?>
        <?php $totalWorkOrderExpense = '0.00'; ?>
        <?php foreach ($purchasePerSupplierSummary->dataProvider->data as $header): ?>
            <?php $purchasePrice = $header->getPurchasePriceReport($startDate, $endDate, $branchId); ?>
            <?php $workOrderExpensePrice = $header->getWorkOrderExpensePriceReport($startDate, $endDate, $branchId); ?>
            <?php $purchasePayment = $header->getPurchasePaymentReport($startDate, $endDate, $branchId); ?>
            <?php $remainingPayable = $purchasePrice + $workOrderExpensePrice - $purchasePayment; ?>
            <?php //if ($purchasePrice > 0): ?>
                <tr class="items1">
                    <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'code')); ?></td>
                    <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'company')); ?></td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                    <td class="width1-4" style="text-align: right">
                        <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0.00', $purchasePrice), Yii::app()->createUrl("report/purchaseSummary/detailPurchaseTransaction", array(
                            "supplierId" => $header->id,
                            "startDate" => $startDate,
                            "endDate" => $endDate,
                        )), array('target' => '_blank'));?>
                    </td>
                    <td class="width1-4" style="text-align: right">
                        <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0.00', $workOrderExpensePrice), Yii::app()->createUrl("report/purchaseSummary/detailWorkOrderExpenseTransaction", array(
                            "supplierId" => $header->id,
                            "startDate" => $startDate,
                            "endDate" => $endDate,
                        )), array('target' => '_blank'));?>
                    </td>
                    <td class="width1-4" style="text-align: right">
                        <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0.00', $purchasePayment), Yii::app()->createUrl("report/purchaseSummary/detailPaymentTransaction", array(
                            "supplierId" => $header->id,
                            "startDate" => $startDate,
                            "endDate" => $endDate,
                        )), array('target' => '_blank'));?>
                    </td>
                    <td class="width1-4" style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $remainingPayable)); ?>
                    </td>
                </tr>
                <?php $totalPurchase += $purchasePrice; ?>
                <?php $totalWorkOrderExpense += $workOrderExpensePrice; ?>
            <?php //endif; ?>
        <?php endforeach; ?>
    </tbody>
    
    <tfoot>
        <tr id="header1">
            <td colspan="3" style="text-align: right">TOTAL PEMBELIAN</td>
            <td class="width1-4" style="text-align: right; font-weight: bold"> 
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPurchase)); ?>
            </td>
            <td class="width1-4" style="text-align: right; font-weight: bold"> 
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalWorkOrderExpense)); ?>
            </td>
        </tr>  
    </tfoot>
</table>