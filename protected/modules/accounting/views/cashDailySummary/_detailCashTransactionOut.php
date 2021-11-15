<table>
    <thead>
        <tr>
            <th style="text-align: center">Transaction #</th>
            <th style="text-align: center">Branch</th>
            <th style="text-align: center">Account</th>
            <th style="text-align: center">Amount</th>
            <th style="text-align: center">Approved By</th>
            <th style="text-align: center">Note</th>
        </tr>
    </thead>
    
    <tbody>
        <?php $totalOut = 0.00; ?>
        <?php foreach ($cashTransactionOutDataProvider->data as $header): ?>
            <?php foreach ($header->cashTransactionDetails as $detail): ?>
                <?php $amountOut = CHtml::value($detail, 'amount'); ?>
                <tr>
                    <td>
                        <?php echo CHtml::link($header->transaction_number, array('javascript:;'), array(
                            'onclick' => 'window.open("' . CController::createUrl('/accounting/cashDailySummary/redirectTransaction', array(
                                "codeNumber" => $header->transaction_number
                            )) . '", "_blank", "top=100, left=225, width=900, height=650"); return false;'
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($header, 'branch.name')); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(CHtml::value($detail, 'coa.name')); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountOut)); ?>
                    </td>
                    <td style="text-align: right">
                        <?php if (!empty($header->cashTransactionApprovals)): ?>
                            <?php echo CHtml::encode($header->cashTransactionApprovals[0]->supervisor->username); ?>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(CHtml::value($detail, 'notes')); ?>
                    </td>
                </tr>
                <?php $totalOut += $amountOut; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
    
    <tfoot>
        <tr>
            <td style="text-align: right" colspan="3">TOTAL</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalOut)); ?></td>
            <td colspan="2">&nbsp;</td>
        </tr>
    </tfoot>
</table>