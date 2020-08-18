<table>
    <thead>
        <tr>
            <th style="text-align: center">Branch</th>
            <?php foreach ($paymentTypes as $paymentType): ?>
                <th style="text-align: center"><?php echo CHtml::encode(CHtml::value($paymentType, 'name')); ?></th>
            <?php endforeach; ?>
            <th style="text-align: center; font-weight: bold">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($paymentInRetailList as $paymentInRetailItem): ?>
            <?php $total = 0.00; ?>
            <tr>
                <?php foreach ($paymentInRetailItem as $i => $paymentInRetail): ?>
                    <td style="text-align: right">
                        <?php if ($i > 0): ?>
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentInRetail)); ?>
                        <?php else: ?>
                            <?php echo CHtml::encode($paymentInRetail); ?>
                        <?php endif; ?>
                    </td>
                    <?php if ($i > 0): ?>
                        <?php $total += $paymentInRetail; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <td style="text-align: right; font-weight: bold">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $total)); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>