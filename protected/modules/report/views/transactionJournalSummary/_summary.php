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
        <?php foreach ($coas as $coa): ?>
            <?php $journalDebitBalance = $coa->getJournalDebitBalance($startDate, $endDate, $branchId); ?>
            <?php $journalCreditBalance = $coa->getJournalCreditBalance($startDate, $endDate, $branchId); ?>
            <?php if (($journalDebitBalance !== 0 || $journalCreditBalance !== 0) && $journalDebitBalance !== $journalCreditBalance): ?>
                <tr>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($coa, 'code')); ?> - 
                        <?php echo CHtml::link($coa->name, Yii::app()->createUrl("report/balanceSheetDetail/jurnalTransaction", array("coaId" => $coa->id, "startDate" => $startDate, "endDate" => $endDate, "branchId" => $branchId)), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: right;">
                        <?php if (empty($coa->coaIds)): ?> 
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $journalDebitBalance)); ?>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: right;">
                        <?php if (empty($coa->coaIds)): ?> 
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $journalCreditBalance)); ?>
                        <?php endif; ?>
                    </td>
                </tr>

                <?php $groupDebitBalance = 0; $groupCreditBalance = 0; ?>
                <?php if (!empty($coa->coaIds)): ?> 
                    <?php foreach ($coa->coaIds as $account): ?>
                        <?php $journalDebitBalance = $account->getJournalDebitBalance($startDate, $endDate, $branchId); ?>
                        <?php $journalCreditBalance = $account->getJournalCreditBalance($startDate, $endDate, $branchId); ?>
                        <?php if (($journalDebitBalance !== 0 || $journalCreditBalance !== 0) && $journalDebitBalance !== $journalCreditBalance): ?>
                            <tr>
                                <td style="font-size: 10px">
                                    <?php echo CHtml::encode(CHtml::value($account, 'code')); ?> - 
                                    <?php echo CHtml::link($account->name, Yii::app()->createUrl("report/profitLossDetail/jurnalTransaction", array("coaId" => $account->id, "startDate" => $startDate, "endDate" => $endDate, "branchId" => $branchId)), array('target' => '_blank')); ?>
                                </td>
                                <td style="text-align: right; font-size: 10px">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $journalDebitBalance)); ?>
                                </td>
                                <td style="text-align: right; font-size: 10px">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $journalCreditBalance)); ?>
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

        <tr>
            <td style="text-align: right; font-weight: bold; border-top: 2px solid; text-transform: uppercase">
                TOTAL 
            </td>

            <td style="text-align: right; font-weight: bold; border-top: 2px solid">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategoryDebitBalance)); ?>
            </td>

            <td style="text-align: right; font-weight: bold; border-top: 2px solid">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategoryCreditBalance)); ?>
            </td>
        </tr>
    </table>
</div>