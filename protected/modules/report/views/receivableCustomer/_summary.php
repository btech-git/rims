<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 40% }
    .width1-2 { width: 15% }
    .width1-3 { width: 15% }
    .width1-4 { width: 15% }
    .width1-5 { width: 15% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Piutang Customer</div>
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
        <?php $totalReceivableIndividual = Customer::getTotalReceivableIndividual($endDate, $branchId); ?>
        <?php $totalPaymentIndividual = Customer::getTotalPaymentIndividual($endDate, $branchId); ?>
        <?php $totalRemainingIndividual = Customer::getTotalRemainingIndividual($endDate, $branchId); ?>
        <tr>
            <td colspan="2" style="text-align: center">Individual</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalReceivableIndividual)); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPaymentIndividual)); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalRemainingIndividual   )); ?></td>
        </tr>
        <?php foreach ($receivableSummary->dataProvider->data as $header): ?>
            <?php $receivableData = $header->getReceivableCustomerReport($endDate, $branchId); ?>
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
                <th><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></th>
                <th><?php echo CHtml::encode(CHtml::value($header, 'customer_type')); ?></th>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalRevenue)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPayment)); ?></td>
                <td style="text-align: right"><?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0', $totalReceivable), array(
                    '/report/receivableCustomer/transactionInfo', 
                    'customerId' => $header->id, 
                    'endDate' => $endDate,
                ), array('target' => '_blank')); ?></td>
            </tr>
            <?php $grandTotalRevenue += $totalRevenue; ?>
            <?php $grandTotalPayment += $totalPayment; ?>
            <?php $grandTotalReceivable += $totalReceivable; ?>
        <?php endforeach; ?>   
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2">TOTAL</td>
            <td class="width1-3" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotalRevenue)); ?></td>
            <td class="width1-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotalPayment)); ?></td>
            <td class="width1-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotalReceivable)); ?></td>
        </tr>
    </tfoot>
</table>