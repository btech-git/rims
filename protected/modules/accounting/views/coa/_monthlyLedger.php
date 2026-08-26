<table>
    <thead>
        <tr>
            <th>Month</th>
            <th>Debit</th>
            <th>Credit</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($coaLedgerSummaryReport as $coaLedgerSummaryItem): ?>
            <tr>
                <td><?php echo CHtml::encode(strftime("%B", mktime(0, 0, 0, $coaLedgerSummaryItem['transaction_month']))); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $coaLedgerSummaryItem['debit'])); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $coaLedgerSummaryItem['credit'])); ?></td>
            </tr>		
        <?php endforeach; ?>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th>Month</th>
            <th>Debit</th>
            <th>Credit</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($coaLedgerAddBeginningBalanceSummaryReport as $coaLedgerAddBeginningBalanceSummaryItem): ?>
            <tr>
                <td><?php echo CHtml::encode(strftime("%B", mktime(0, 0, 0, $coaLedgerAddBeginningBalanceSummaryItem['transaction_month']))); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $coaLedgerAddBeginningBalanceSummaryItem['debit'])); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", $coaLedgerAddBeginningBalanceSummaryItem['credit'])); ?></td>
            </tr>		
        <?php endforeach; ?>
    </tbody>
</table>