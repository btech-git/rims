<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 30% }
    .width1-2 { width: 15% }
    .width1-3 { width: 15% }
    .width1-4 { width: 15% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <?php $branch = Branch::model()->findByPk($branchId); ?>
    <div style="font-size: larger">Raperind Motor <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></div>
    <div style="font-size: larger">Hutang Supplier Summary</div>
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
        <?php $totalDebitSum = '0.00'; ?>
        <?php $totalCreditSum = '0.00'; ?>
        <?php $totalRemainingSum = '0.00'; ?>
        <?php foreach ($payableSummary->dataProvider->data as $header): ?>
            <?php $payablePurchaseData = $header->getPayableSupplierReport($endDate, $branchId); ?>
            <?php //$payableWorkOrderData = $header->getPayableWorkOrderSupplierReport($endDate, $branchId); ?>
            <?php $totalDebit = '0.00'; ?>
            <?php $totalCredit = '0.00'; ?>
            <?php foreach ($payablePurchaseData as $payableRow): ?>
                <?php $transactionNumber = $payableRow['kode_transaksi']; ?>
                <?php if ($payableRow['transaction_type'] == 'D'): ?>
                    <?php $amountDebit = $payableRow['amount']; ?>
                    <?php $amountCredit = '0.00'; ?>
                <?php else: ?>
                    <?php $amountDebit = '0.00'; ?>
                    <?php $amountCredit = $payableRow['amount']; ?>
                <?php endif; ?>

                <?php $totalDebit += $amountDebit; ?>
                <?php $totalCredit += $amountCredit; ?>
                <?php $remaining = $totalDebit - $totalCredit; ?>
            <?php endforeach; ?>
        
            <tr class="items1">
                <td style="font-weight: bold">
                    <?php echo CHtml::encode(CHtml::value($header, 'code')); ?> - 
                    <?php echo CHtml::encode(CHtml::value($header, 'name')); ?>
                </td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalDebit)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalCredit)); ?></td>
                <td style="text-align: right">
                    <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0', $remaining), array(
                        '/report/payableSupplier/transactionInfo', 
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
            <td>TOTAL</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalDebitSum)); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalCreditSum)); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalRemainingSum)); ?></td>
        </tr>
    </tfoot>
</table>