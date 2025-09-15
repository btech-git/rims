<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 30% }
    .width1-2 { width: 15% }
    .width1-3 { width: 15% }
    .width1-4 { width: 15% }
    
    .width2-1 { width: 15% }
    .width2-2 { width: 15% }
    .width2-3 { width: 15% }
    .width2-4 { width: 10% }
    .width2-5 { width: 15% }
    .width2-6 { width: 15% }
    .width2-7 { width: 15% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></div>
    <div style="font-size: larger">Laporan Hutang Supplier Summary</div>
    <div><?php echo 'Per Tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Name</th>
            <th class="width1-2">Total Invoice</th>
            <th class="width1-3">Payment</th>
            <th class="width1-4">Remaining</th>

        </tr>
    </thead>
    <tbody>
        <?php $grandTotalPurchase = 0.00; ?>
        <?php $grandTotalPayment = 0.00; ?>
        <?php $grandTotalPayable = 0.00; ?>
        <?php foreach ($payableSummary->dataProvider->data as $header): ?>
            <?php $payableData = $header->getPayableSupplierReport($endDate, $branchId); ?>
            <?php $totalRevenue = 0.00; ?>
            <?php $totalPayment = 0.00; ?>
            <?php $totalPayable = 0.00; ?>
            <?php foreach ($payableData as $payableRow): ?>
                <?php $revenue = $payableRow['total_price']; ?>
                <?php $paymentAmount = $payableRow['payment_amount']; ?>
                <?php $paymentLeft = $payableRow['payment_left']; ?>
                <?php $totalRevenue += $revenue; ?>
                <?php $totalPayment += $paymentAmount; ?>
                <?php $totalPayable += $paymentLeft; ?>
            <?php endforeach; ?>
            <tr class="items1">
                <th class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></th>
                <td class="width1-2" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalRevenue)); ?></td>
                <td class="width1-3" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPayment)); ?></td>
                <td class="width1-4" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPayable)); ?></td>
            </tr>
            <?php $grandTotalPurchase += $totalRevenue; ?>
            <?php $grandTotalPayment += $totalPayment; ?>
            <?php $grandTotalPayable += $totalPayable; ?>
        <?php endforeach; ?>   
    </tbody>
    <tfoot>
        <tr>
            <td>TOTAL</td>
            <td class="width1-2" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotalPurchase)); ?></td>
            <td class="width1-3" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotalPayment)); ?></td>
            <td class="width1-4" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotalPayable)); ?></td>
        </tr>
    </tfoot>
</table>