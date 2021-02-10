<table>
    <thead>
        <tr>
            <th style="text-align: center">Customer</th>
            <th style="text-align: center">Payment Type</th>
            <th style="text-align: center">Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php $grandTotal = 0; ?>
        <?php foreach ($paymentInDataProvider->data as $paymentIn): ?>
            <tr>
                <td><?php echo CHtml::encode(CHtml::value($paymentIn, 'customer.name')); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($paymentIn, 'paymentType.name')); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($paymentIn, 'payment_amount'))); ?></td>
            </tr>
            <?php $grandTotal += $paymentIn->payment_amount; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="text-align: right">Total</td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?></td>
        </tr>
    </tfoot>
</table>