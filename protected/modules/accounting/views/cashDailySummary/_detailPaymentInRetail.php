<table>
    <thead>
        <tr>
            <th style="text-align: center">Branch</th>
            <?php $paymentDailyTotals = array(); ?>
            <?php foreach ($paymentTypes as $paymentType): ?>
                <th style="text-align: center"><?php echo CHtml::encode(CHtml::value($paymentType, 'name')); ?></th>
                <?php $paymentDailyTotals[$paymentType->id] = '0.00'; ?>
            <?php endforeach; ?>
            <?php $dailyTotal = '0.00'; ?>
            <th style="text-align: center; font-weight: bold">Total</th>
            <th></th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($paymentInRetailList as $paymentInRetailBranchId => $paymentInRetailItem): ?>
            <?php $totalPerBranch = '0.00'; ?>
            <tr>
                <?php foreach ($paymentInRetailItem as $paymentTypeId => $paymentInRetail): ?>
                    <td style="text-align: right">
                        <?php if ($paymentTypeId > 0): ?>
                            <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0', $paymentInRetail), array('javascript:;'), array(
                                'onclick' => 'window.open("' . CController::createUrl('/accounting/cashDailySummary/create', array(
                                    "transactionDate" => $transactionDate, 
                                    "branchId" => $paymentInRetailBranchId, 
                                    "paymentTypeId" => $paymentTypeId
                                )) . '", "_blank", "top=100, left=225, width=900, height=650"); return false;'
                            )); ?> 
                            <?php $paymentDailyTotals[$paymentTypeId] += $paymentInRetail; ?>
                        <?php else: ?>
                            <?php echo CHtml::encode($paymentInRetail); ?>
                        <?php endif; ?>
                    </td>
                    <?php if ($paymentTypeId > 0): ?>
                        <?php $totalPerBranch += $paymentInRetail; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <td style="text-align: right; font-weight: bold">
                    <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0', $totalPerBranch), array('javascript:;'), array(
                        'onclick' => 'window.open("' . CController::createUrl('/accounting/cashDailySummary/approval', array(
                            "transactionDate" => $transactionDate, 
                            "branchId" => $paymentInRetailBranchId, 
                        )) . '", "_blank", "top=100, left=225, width=900, height=650"); return false;'
                    )); ?>
                </td>
                <td>
                    <?php echo CHtml::link('Approve', Yii::app()->createUrl("accounting/cashDailySummary/approval", array(
                        "branchId" => $paymentInRetailBranchId,
                        "transactionDate" => $transactionDate,
                    )), array('target' => '_blank', 'class'=>'button warning')); ?>
                </td>
            </tr>
            <?php $dailyTotal += $totalPerBranch; ?>
        <?php endforeach; ?>
    </tbody>
    
    <tfoot>
        <tr>
            <td style="text-align: right">Total Daily Cash</td>
            <?php foreach ($paymentTypes as $paymentType): ?>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $paymentDailyTotals[$paymentType->id])); ?>
                </td>
            <?php endforeach; ?>
            <td style="text-align: right; font-weight: bold">
                <?php echo CHtml::hiddenField('TotalDaily', $dailyTotal); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $dailyTotal)); ?>
            </td>
            <td></td>
        </tr>
    </tfoot>
</table>