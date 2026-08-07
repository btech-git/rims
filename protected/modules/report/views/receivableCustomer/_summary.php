<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 40% }
    .width1-2 { width: 15% }
    .width1-3 { width: 15% }
    .width1-4 { width: 15% }
    .width1-5 { width: 15% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Piutang Customer Summary</div>
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
        <?php $grandTotalRevenue = '0.00'; ?>
        <?php $grandTotalPayment = '0.00'; ?>
        <?php $grandTotalReceivable = '0.00'; ?>
        <?php $totalReceivableIndividual = Customer::getTotalReceivableIndividual($endDate, $branchId); ?>
        <?php $totalPaymentIndividual = Customer::getTotalPaymentIndividual($endDate, $branchId); ?>
        <?php $totalRemainingIndividual = Customer::getTotalRemainingIndividual($endDate, $branchId); ?>
        <tr>
            <td colspan="2" style="text-align: center">Individual</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalReceivableIndividual)); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPaymentIndividual)); ?></td>
            <td style="text-align: right">
                <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0', $totalRemainingIndividual), array(
                    '/report/receivableCustomer/transactionRetailInfo', 
                    'endDate' => $endDate,
                ), array('target' => '_blank')); ?>
            </td>
        </tr>
        <?php $totalDebitSum = '0.00'; ?>
        <?php $totalCreditSum = '0.00'; ?>
        <?php $totalRemainingSum = '0.00'; ?>
        <?php foreach ($receivableSummary->dataProvider->data as $header): ?>
            <?php $receivableData = $header->getReceivableCustomerReport($endDate, $branchId); ?>
            <?php $totalDebit = '0.00'; ?>
            <?php $totalCredit = '0.00'; ?>
            <?php foreach ($receivableData as $receivableRow): ?>
                <?php $transactionNumber = $receivableRow['kode_transaksi']; ?>
                <?php if ($receivableRow['transaction_type'] == 'D'): ?>
                    <?php $amountDebit = $receivableRow['amount']; ?>
                    <?php $amountCredit = '0.00'; ?>
                <?php else: ?>
                    <?php $amountDebit = '0.00'; ?>
                    <?php $amountCredit = $receivableRow['amount']; ?>
                <?php endif; ?>

                <?php $totalDebit += $amountDebit; ?>
                <?php $totalCredit += $amountCredit; ?>
                <?php $remaining = $totalDebit - $totalCredit; ?>
            <?php endforeach; ?>
                
            <tr>
                <td style="font-weight: bold">
                    <?php echo CHtml::encode(CHtml::value($header, 'code')); ?> - 
                    <?php echo CHtml::encode(CHtml::value($header, 'name')); ?>
                </td>
                <td>Company</td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalDebit)); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalCredit)); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0', $remaining), array(
                        '/report/receivableCustomer/transactionInfo', 
                        'coaId' => $header->id,
                        'branchId' => $branchId,
                        'endDate' => $endDate,
                    ), array('target' => '_blank')); ?>
                </td>
            </tr>

            <?php $totalDebitSum += $totalDebit; ?>
            <?php $totalCreditSum += $totalCredit; ?>
            <?php $totalRemainingSum += $remaining; ?>
        <?php endforeach; ?>   
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2">TOTAL</td>
            <td class="width1-3" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalDebitSum)); ?></td>
            <td class="width1-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalCreditSum)); ?></td>
            <td class="width1-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalRemainingSum)); ?></td>
        </tr>
    </tfoot>
</table>