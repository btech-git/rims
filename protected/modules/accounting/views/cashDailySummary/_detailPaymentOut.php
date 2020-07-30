<table>
    <thead>
        <tr>
            <th style="text-align: center">Branch</th>
            <th style="text-align: center">Supplier</th>
            <th style="text-align: center">Payment Type</th>
            <th style="text-align: center">Amount</th>
            <th style="text-align: center">Payment #</th>
            <th style="text-align: center">Notes</th> 
        </tr>
    </thead>
    <tbody>
        <?php $grandTotal = 0; ?>
        <?php foreach ($paymentOutDataProvider->data as $paymentOut): ?>
            <?php $totalAmount = $paymentOut->getTotalAmount($branchId, $transactionDate); ?>
            <tr>
                <td><?php echo CHtml::encode(CHtml::value($paymentOut, 'branch.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($paymentOut, 'supplier.name')); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($paymentOut, 'paymentType.name')); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalAmount)); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($paymentOut, 'payment_number')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($paymentOut, 'notes')); ?></td>
            </tr>
            <?php $grandTotal += $totalAmount; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" style="text-align: right; border-top: 1px solid">Total</td>
            <td style="text-align: right; border-top: 1px solid">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?>
            </td>
        </tr>
    </tfoot>
</table>