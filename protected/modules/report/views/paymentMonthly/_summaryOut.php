<fieldset>
    <legend>Transaksi Kas Keluar</legend>
    <table>
        <thead>
            <tr>
                <th style="text-align: center"></th>
                <?php $paymentDailyTotals = array(); ?>
                <?php foreach ($paymentTypes as $paymentType): ?>
                    <th style="text-align: center"><?php echo CHtml::encode(CHtml::value($paymentType, 'name')); ?></th>
                    <?php $paymentDailyTotals[$paymentType->id] = '0.00'; ?>
                <?php endforeach; ?>
                <?php $dailyTotal = '0.00'; ?>
                <th style="text-align: center; font-weight: bold">Total</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($paymentOutList as $paymentOutDate => $paymentOutItem): ?>
                <?php $totalPerDate = '0.00'; ?>
                <tr>
                    <?php foreach ($paymentOutItem as $paymentTypeId => $paymentOutRetail): ?>
                        <td style="text-align: right">
                            <?php if ($paymentTypeId > 0): ?>
                                <?php /*echo CHtml::link(Yii::app()->numberFormatter->format('#,##0', $paymentOutRetail), array('javascript:;'), array(
                                    'onclick' => 'window.open("' . CController::createUrl('/accounting/cashDailySummary/showTransactionDetailByTypeBranchDate', array(
                                        "transactionDate" => $transactionDate, 
                                        "branchId" => $paymentOutDate, 
                                        "paymentTypeId" => $paymentTypeId
                                    )) . '", "_blank", "top=100, left=225, width=900, height=650"); return false;'
                                ));*/ ?> 
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentOutRetail)); ?>
                                <?php $paymentDailyTotals[$paymentTypeId] += $paymentOutRetail; ?>
                            <?php else: ?>
                                <?php echo CHtml::encode($paymentOutRetail); ?>
                            <?php endif; ?>
                        </td>
                        <?php if ($paymentTypeId > 0): ?>
                            <?php $totalPerDate += $paymentOutRetail; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <td style="text-align: right; font-weight: bold">
                        <?php /*echo CHtml::link(Yii::app()->numberFormatter->format('#,##0', $totalPerDate), array('javascript:;'), array(
                            'onclick' => 'window.open("' . CController::createUrl('/accounting/cashDailySummary/approval', array(
                                "transactionDate" => $transactionDate, 
                                "branchId" => $paymentOutDate, 
                            )) . '", "_blank", "top=100, left=225, width=900, height=650"); return false;'
                        ));*/ ?>
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPerDate)); ?>
                    </td>
                </tr>
                <?php $dailyTotal += $totalPerDate; ?>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr>
                <td style="text-align: right">Total Monthly Cash</td>
                <?php foreach ($paymentTypes as $paymentType): ?>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentDailyTotals[$paymentType->id])); ?>
                    </td>
                <?php endforeach; ?>
                <td style="text-align: right; font-weight: bold">
                    <?php //echo CHtml::hiddenField('TotalMonthly', $dailyTotal); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $dailyTotal)); ?>
                </td>
            </tr>
        </tfoot>
    </table>
</fieldset>