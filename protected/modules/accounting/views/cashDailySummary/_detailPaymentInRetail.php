<table>
    <thead>
        <tr>
            <th style="text-align: center">Branch</th>
            <?php foreach ($paymentTypes as $paymentType): ?>
                <th style="text-align: center"><?php echo CHtml::encode(CHtml::value($paymentType, 'name')); ?></th>
            <?php endforeach; ?>
            <th style="text-align: center">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($branchDataProvider->data as $branch): ?>
            <?php $branchTotalAmounts = $branch->getPaymentInRetailTotalAmounts(); ?>
            <?php $totalAmount = 0; ?>
            <tr>
                <td><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></td>
                <?php foreach ($paymentTypes as $paymentType): ?>
                    <?php $index = -1; ?>
                    <?php foreach ($branchTotalAmounts as $i => $branchTotalAmount): ?>
                        <?php if ($branchTotalAmount['payment_type_id'] == $paymentType->id): ?>
                            <?php $index = $i; ?>
                            <?php break; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if ($index >= 0): ?>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($branchTotalAmounts[$i], 'total_amount'))); ?></td>
                    <?php else: ?>
                        <td style="text-align: right">0</td>
                    <?php endif; ?>
                    <?php //$totalAmount += CHtml::value($branchTotalAmounts[$i], 'total_amount'); ?>
                <?php endforeach; ?>
                <td><?php //echo CHtml::encode($totalAmount); ?></td>
            </tr>
        <?php endforeach; ?>
        <?php /*$grandTotal = 0; ?>
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
        <?php endforeach; */?>
    </tbody>
<!--    <tfoot>
        <tr>
            <td style="text-align: right; border-top: 1px solid" colspan="2">Total</td>
            <td style="text-align: right; border-top: 1px solid">
                <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?>
            </td>
        </tr>
    </tfoot>-->
</table>