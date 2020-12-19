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
        <?php foreach ($paymentInRetailList as $paymentInRetailBranchId => $paymentInRetailItem): ?>
            <?php $total = 0.00; ?>
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
                        <?php else: ?>
                            <?php echo CHtml::encode($paymentInRetail); ?>
                        <?php endif; ?>
                    </td>
                    <?php if ($paymentTypeId > 0): ?>
                        <?php $total += $paymentInRetail; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <td style="text-align: right; font-weight: bold">
                    <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0', $total), array('javascript:;'), array(
                        'onclick' => 'window.open("' . CController::createUrl('/accounting/cashDailySummary/approval', array(
                            "transactionDate" => $transactionDate, 
                            "branchId" => $paymentInRetailBranchId, 
                        )) . '", "_blank", "top=100, left=225, width=900, height=650"); return false;'
                    )); ?>
                    <?php //echo CHtml::link(Yii::app()->numberFormatter->format('#,##0', $total), array("/accounting/cashDailySummary/approval", "transactionDate" => $transactionDate, "branchId" => $paymentInRetailBranchId, ), array('target' => '_blank')); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>