<table>
    <thead>
        <tr>
            <th style="text-align: center">Account</th>
            <th style="text-align: center">In</th>
            <th style="text-align: center">Out</th>
            <th style="text-align: center">Note</th>
        </tr>
    </thead>
    <tbody>
        <?php $totalIn = 0.00; $totalOut = 0.00; ?>
        <?php foreach ($cashTransactionDataProvider->data as $header): ?>
            <?php foreach ($header->cashTransactionDetails as $detail): ?>
                <?php 
                $amountIn = ($header->transaction_type == 'In') ? CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($cashTransaction, 'amount'))) : 0.00; 
                $amountOut = ($header->transaction_type == 'Out') ? CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($cashTransaction, 'amount'))) : 0.00;
                ?>
                <tr>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(CHtml::value($detail, 'account.name')); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo $AmountIn; ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo $amountOut; ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(CHtml::value($detail, 'notes')); ?>
                    </td>
                </tr>
                <?php $totalIn += $AmountIn; $totalOut += $amountOut; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right">TOTAL</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalIn)); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalOut)); ?></td>
            <td>&nbsp;</td>
        </tr>
    </tfoot>
<!--    <tbody>
            <tr>
                <td style="text-align: right">
                    <?php /*echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $cashTransaction->getTotalDebitAmount($branchId, $transactionDate))); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $cashTransaction->getTotalCreditAmount($branchId, $transactionDate))); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $cashTransaction->getTotalAmount($branchId, $transactionDate)));*/ ?>
                </td>
            </tr>
    </tbody>-->
</table>