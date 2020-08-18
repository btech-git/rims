<table>
    <thead>
        <tr>
            <th style="text-align: center">Branch</th>
            <th style="text-align: center">Account</th>
            <th style="text-align: center">Amount</th>
            <th style="text-align: center">Approved By</th>
            <th style="text-align: center">Note</th>
        </tr>
    </thead>
    
    <tbody>
        <?php $totalIn = 0.00; ?>
        <?php foreach ($cashTransactionInDataProvider->data as $header): ?>
            <?php foreach ($header->cashTransactionDetails as $detail): ?>
                <?php $amountIn = CHtml::value($detail, 'amount'); ?>
                <tr>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($header, 'branch.name')); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(CHtml::value($detail, 'coa.name')); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountIn)); ?>
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
                <?php $totalIn += $amountIn; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
    
    <tfoot>
        <tr>
            <td style="text-align: right" colspan="2">TOTAL</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalIn)); ?></td>
            <td colspan="2">&nbsp;</td>
        </tr>
    </tfoot>
</table>