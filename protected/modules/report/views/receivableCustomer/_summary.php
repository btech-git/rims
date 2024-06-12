<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 30% }
    .width1-2 { width: 30% }
    
    .width2-1 { width: 12% }
    .width2-2 { width: 12% }
    .width2-3 { width: 15% }
    .width2-4 { width: 10% }
    .width2-5 { width: 12% }
    .width2-6 { width: 12% }
    .width2-7 { width: 12% }
    .width2-8 { width: 15% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Piutang Customer Summary</div>
    <div><?php echo 'Per tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Name</th>
            <th class="width1-2">Type</th>
            <th class="width1-3">Total Invoice</th>
            <th class="width1-4">Payment</th>
            <th class="width1-5">Remaining</th>
        </tr>
    </thead>
    <tbody>
        <?php $grandTotalRevenue = 0.00; ?>
        <?php $grandTotalPayment = 0.00; ?>
        <?php $grandTotalReceivable = 0.00; ?>
        <?php foreach ($receivableSummary->dataProvider->data as $header): ?>
            <?php $receivableData = $header->getReceivableReport($endDate, $branchId, $insuranceCompanyId, $plateNumber); ?>
            <?php $totalRevenue = 0.00; ?>
            <?php $totalPayment = 0.00; ?>
            <?php $totalReceivable = 0.00; ?>
            <?php foreach ($receivableData as $receivableRow): ?>
                <?php $revenue = $receivableRow['total_price']; ?>
                <?php $paymentAmount = $receivableRow['payment_amount']; ?>
                <?php $paymentLeft = $receivableRow['payment_left']; ?>
                <?php $totalRevenue += $revenue; ?>
                <?php $totalPayment += $paymentAmount; ?>
                <?php $totalReceivable += $paymentLeft; ?>
            <?php endforeach; ?>
            <tr class="items1">
                <th class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></th>
                <th class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'customer_type')); ?></th>
                <td class="width1-3" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalRevenue)); ?></td>
                <td class="width1-4" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPayment)); ?></td>
                <td class="width1-5" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalReceivable)); ?></td>
            </tr>
            <?php $grandTotalRevenue += $totalRevenue; ?>
            <?php $grandTotalPayment += $totalPayment; ?>
            <?php $grandTotalReceivable += $totalReceivable; ?>
        <?php endforeach; ?>   
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2">TOTAL</td>
            <td class="width1-3" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotalRevenue)); ?></td>
            <td class="width1-4" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotalPayment)); ?></td>
            <td class="width1-5" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotalReceivable)); ?></td>
        </tr>
    </tfoot>
</table>