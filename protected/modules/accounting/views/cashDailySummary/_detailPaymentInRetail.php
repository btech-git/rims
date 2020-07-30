<table>
    <thead>
        <tr>
            <th style="text-align: center">Branch</th>
            <th style="text-align: center">Payment Type</th>
            <th style="text-align: center">Amount</th>
        </tr>
    </thead>
    <tbody>
        <?php $grandTotal = 0; ?>
        <?php foreach ($paymentInRetailDataProvider->data as $data): ?>
            <?php $totalAmount = $data['total_amount']; ?>
            <tr>
                <td>
                    <?php echo CHtml::encode($data['branch_name']); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::encode($data['payment_type']); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalAmount)); ?>
                </td>
            </tr>
            <?php $grandTotal += $totalAmount; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right; border-top: 1px solid" colspan="2">Total</td>
            <td style="text-align: right; border-top: 1px solid">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?>
            </td>
        </tr>
    </tfoot>
</table>