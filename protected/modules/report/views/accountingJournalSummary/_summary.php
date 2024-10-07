<div class="relative">
    <div style="font-weight: bold; text-align: center">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <div style="font-size: larger"><?php echo CHtml::encode(($branch === null) ? '' : $branch->name); ?></div>
        <div style="font-size: larger">Laporan Jurnal Umum Rekap</div>
        <div><?php echo ' YTD: &nbsp;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' - ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
    </div>

    <br />

    <table style="width: 60%; margin: 0 auto; border-spacing: 0pt">
        <tr>
            <th style="text-align: center">Chart of Account</th>
            <th style="text-align: center">Debit</th>
            <th style="text-align: center">Credit</th>
        </tr>
        <?php $accountCategoryDebitBalance = 0.00; ?>
        <?php $accountCategoryCreditBalance = 0.00; ?>
        <?php foreach ($coaSubCategories as $coaSubCategory): ?>
            <?php $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $coaSubCategory->id), array('order' => 't.code ASC')); ?>
            <?php foreach ($coas as $coa): ?>
                <?php $journalDebitBalance = $coa->getJournalDebitBalance($startDate, $endDate, $branchId, $transactionType); ?>
                <?php $journalCreditBalance = $coa->getJournalCreditBalance($startDate, $endDate, $branchId, $transactionType); ?>
                <?php if ($journalDebitBalance !== 0 || $journalCreditBalance !== 0): // && $journalDebitBalance !== $journalCreditBalance): ?>
                    <tr>
                        <td>
                            <?php echo CHtml::encode(CHtml::value($coa, 'code')); ?> - 
                            <?php echo CHtml::link($coa->name, Yii::app()->createUrl("report/accountingJournalSummary/jurnalTransaction", array(
                                "CoaId" => $coa->id, 
                                "StartDate" => $startDate, 
                                "EndDate" => $endDate, 
                                "BranchId" => $branchId
                            )), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: right;">
                            <?php if (empty($coa->coaIds)): ?> 
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $journalDebitBalance)); ?>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: right;">
                            <?php if (empty($coa->coaIds)): ?> 
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $journalCreditBalance)); ?>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <?php $groupDebitBalance = 0; $groupCreditBalance = 0; ?>
                    <?php if (!empty($coa->coaIds)): ?> 
                        <?php $coaIds = Coa::model()->findAllByAttributes(array('coa_id' => $coa->id), array('order' => 't.code ASC')); ?>
                        <?php foreach ($coaIds as $account): ?>
                            <?php $journalDebitBalance = $account->getJournalDebitBalance($startDate, $endDate, $branchId, $transactionType); ?>
                            <?php $journalCreditBalance = $account->getJournalCreditBalance($startDate, $endDate, $branchId, $transactionType); ?>
                            <?php if (($journalDebitBalance !== 0 || $journalCreditBalance !== 0) && $journalDebitBalance !== $journalCreditBalance): ?>
                                <tr>
                                    <td style="font-size: 10px">
                                        <?php echo CHtml::encode(CHtml::value($account, 'code')); ?> - 
                                        <?php echo CHtml::link($account->name, Yii::app()->createUrl("report/transactionJournalSummary/jurnalTransaction", array(
                                            "CoaId" => $account->id, 
                                            "StartDate" => $startDate, 
                                            "EndDate" => $endDate, 
                                            "BranchId" => $branchId
                                        )), array('target' => '_blank')); ?>
                                    </td>
                                    <td style="text-align: right; font-size: 10px">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $journalDebitBalance)); ?>
                                    </td>
                                    <td style="text-align: right; font-size: 10px">
                                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $journalCreditBalance)); ?>
                                    </td>
                                </tr>
                                <?php $groupDebitBalance += $journalDebitBalance; ?>
                                <?php $groupCreditBalance += $journalCreditBalance; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
                <?php $accountCategoryDebitBalance += $journalDebitBalance; ?>
                <?php $accountCategoryCreditBalance += $journalCreditBalance; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>

        <tr>
            <td style="text-align: right; font-weight: bold; border-top: 2px solid; text-transform: uppercase">
                TOTAL 
            </td>

            <td style="text-align: right; font-weight: bold; border-top: 2px solid">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $accountCategoryDebitBalance)); ?>
            </td>

            <td style="text-align: right; font-weight: bold; border-top: 2px solid">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $accountCategoryCreditBalance)); ?>
            </td>
        </tr>
    </table>
</div>