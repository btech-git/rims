<table>
    <thead>
        <tr>
            <th style="text-align: center">Branch</th>
            <th style="text-align: center">Customer</th>
            <th style="text-align: center">Payment Type</th>
            <th style="text-align: center">Amount</th>
            <th style="text-align: center">Payment #</th>
            <th style="text-align: center">Notes</th>
        </tr>
    </thead>
    <tbody>
        <?php $grandTotal = 0; ?>
        <?php foreach ($paymentInWholesaleDataProvider->data as $paymentIn): ?>
            <?php $totalAmount = $paymentIn->total_amount; ?>
            <tr>
                <td><?php echo CHtml::encode(CHtml::value($paymentIn, 'branch.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($paymentIn, 'customer.name')); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($paymentIn, 'paymentType.name')); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalAmount)); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($paymentIn, 'payment_number')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($paymentIn, 'notes')); ?></td>
            </tr>
            <?php $grandTotal += $totalAmount; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" style="text-align: right; border-top: 1px solid">Total</td>
            <td style="text-align: right; border-top: 1px solid"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?></td>
        </tr>
    </tfoot>
</table>