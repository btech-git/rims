<table>
    <thead>
        <tr>
            <th style="text-align: center">Branch</th>
            <?php $transferDailyTotals = array(); ?>
            <?php $paymentDailyTotals = array(); ?>
            <?php foreach ($companyBanks as $companyBank): ?>
                <th style="text-align: center"><?php echo CHtml::encode(CHtml::value($companyBank, 'account_name')); ?></th>
                <?php $transferDailyTotals[$companyBank->id] = '0.00'; ?>
            <?php endforeach; ?>
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
                <td style="text-align: right"><?php echo CHtml::encode($paymentInRetailItem['name']); ?></td>
                <?php foreach ($companyBanks as $companyBank): ?>
                    <?php $bankTransfer = isset($bankTransferList[$paymentInRetailBranchId][$companyBank->id]) ? $bankTransferList[$paymentInRetailBranchId][$companyBank->id] : '0.00'; ?>
                    <td style="text-align: right">
                        <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0', $bankTransfer), array('javascript:;'), array(
                            'onclick' => 'window.open("' . CController::createUrl('/accounting/cashDailySummary/showTransactionDetailByTypeBranchDate', array(
                                "transactionDate" => $transactionDate, 
                                "branchId" => $paymentInRetailBranchId, 
//                                "paymentTypeId" => $paymentTypeId
                            )) . '", "_blank", "top=100, left=225, width=900, height=650"); return false;'
                        )); ?> 
                        <?php $transferDailyTotals[$companyBank->id] += $bankTransfer; ?>
                        <?php $totalPerBranch += $bankTransfer; ?>
                    </td>
                <?php endforeach; ?>
                <?php foreach ($paymentInRetailItem as $paymentTypeId => $paymentInRetail): ?>
                    <?php if ($paymentTypeId != 'name' && $paymentTypeId != 5):  ?>
                        <td style="text-align: right">
                            <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0', $paymentInRetail), array('javascript:;'), array(
                                'onclick' => 'window.open("' . CController::createUrl('/accounting/cashDailySummary/showTransactionDetailByTypeBranchDate', array(
                                    "transactionDate" => $transactionDate, 
                                    "branchId" => $paymentInRetailBranchId, 
                                    "paymentTypeId" => $paymentTypeId
                                )) . '", "_blank", "top=100, left=225, width=900, height=650"); return false;'
                            )); ?> 
                            <?php $paymentDailyTotals[$paymentTypeId] += $paymentInRetail; ?>
                        </td>
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
                    <?php $cashDailyApproval = CashDailySummary::model()->findByAttributes(array(
                        'transaction_date' => $transactionDate, 
                        'branch_id' => $paymentInRetailBranchId,
                    )); ?>
                    <?php if (empty($cashDailyApproval)): ?>
                        <?php echo CHtml::link('Approve', Yii::app()->createUrl("accounting/cashDailySummary/approval", array(
                            "branchId" => $paymentInRetailBranchId,
                            "transactionDate" => $transactionDate,
                        )), array('target' => '_blank', 'class'=>'button warning')); ?>
                    <?php else: ?> 
                        <?php echo 'Approved'; ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php $dailyTotal += $totalPerBranch; ?>
        <?php endforeach; ?>
    </tbody>
    
    <tfoot>
        <tr>
            <td style="text-align: right">Total Daily Cash</td>
            <?php foreach ($companyBanks as $companyBank): ?>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $transferDailyTotals[$companyBank->id])); ?>
                </td>
            <?php endforeach; ?>
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