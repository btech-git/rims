<table>
    <thead>
        <tr>
            <th style="text-align: center">No</th>
            <th style="text-align: center">Transaction #</th>
            <th style="text-align: center">Tanggal</th>
            <th style="text-align: center">Customer</th>
            <th style="text-align: center">Amount</th>
            <th style="text-align: center">Note</th>
        </tr>
    </thead>
    
    <tbody>
        <?php $grandTotal = 0.00; ?>
        <?php foreach ($retailTransactionDataProvider->data as $i => $header): ?>
            <?php $totalPrice = CHtml::value($header, 'grand_total'); ?>
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
                    <?php echo CHtml::encode(CHtml::value($header, 'transaction_date')); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPrice)); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(CHtml::value($header, 'status')); ?>
                </td>
            </tr>
            <?php $grandTotal += $totalPrice; ?>
        <?php endforeach; ?>
    </tbody>
    
    <tfoot>
        <tr>
            <td style="text-align: right" colspan="4">TOTAL</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?></td>
            <td>&nbsp;</td>
        </tr>
    </tfoot>
</table>