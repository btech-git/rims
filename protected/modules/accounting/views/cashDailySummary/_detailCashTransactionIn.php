<table>
    <thead>
        <tr>
            <th style="text-align: center">No</th>
            <th style="text-align: center">Transaction #</th>
            <th style="text-align: center">Account</th>
            <th style="text-align: center">Amount</th>
            <th style="text-align: center">Branch</th>
            <th style="text-align: center">Type</th>
            <th style="text-align: center">Created By</th>
            <th style="text-align: center">Approved By</th>
        </tr>
    </thead>
    
    <tbody>
        <?php $totalIn = 0.00; ?>
        <?php foreach ($cashTransactionInDataProvider->data as $i => $header): ?>
            <?php $amountIn = CHtml::value($header, 'credit_amount'); ?>
            <tr>
                <td><?php echo CHtml::encode($i + 1); ?></td>
                <td>
                    <?php echo CHtml::link($header->transaction_number, array('javascript:;'), array(
                        'onclick' => 'window.open("' . CController::createUrl('/accounting/cashDailySummary/redirectTransaction', array(
                            "codeNumber" => $header->transaction_number
                        )) . '", "_blank", "top=100, left=225, width=900, height=650"); return false;'
                    )); ?>
                </td>
                <td>
                    <?php echo CHtml::encode(CHtml::value($header, 'coa.name')); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountIn)); ?>
                </td>
                <td>
                    <?php echo CHtml::encode(CHtml::value($header, 'branch.name')); ?>
                </td>
                <td>
                    <?php echo CHtml::encode(CHtml::value($header, 'paymentType.name')); ?>
                </td>
                <td>
                    <?php echo CHtml::encode(CHtml::value($header, 'user.username')); ?>
                </td>
                <td>
                    <?php if (!empty($header->cashTransactionApprovals)): ?>
                        <?php echo CHtml::encode($header->cashTransactionApprovals[0]->supervisor->username); ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php $totalIn += $amountIn; ?>
        <?php endforeach; ?>
    </tbody>
    
    <tfoot>
        <tr>
            <td style="text-align: right" colspan="3">TOTAL</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalIn)); ?></td>
            <td colspan="4">&nbsp;</td>
        </tr>
    </tfoot>
</table>