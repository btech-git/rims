<div class="relative">
    <div style="font-weight: bold; text-align: center">
        <div style="font-size: larger">Raperind Motor</div>
        <div style="font-size: larger">Ringkasan Buku Besar Semua Cabang</div>
        <div><?php echo ' YTD: &nbsp;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' - ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
    </div>

    <br />

    <table style="margin: 0 auto; border-spacing: 0pt">
        <thead>
            <tr>
                <th style="text-align: center"></th>
                <?php foreach ($branches as $branch): ?>
                    <th style="text-align: center" colspan="2"><?php echo CHtml::encode(CHtml::value($branch, 'code')); ?></th>
                <?php endforeach; ?>
                    <th colspan="2"></th>
            </tr>
            <tr>
                <th style="text-align: center; min-width: 400px">Chart of Account</th>
                <?php foreach ($branches as $branch): ?>
                    <th style="text-align: center">Debit</th>
                    <th style="text-align: center">Credit</th>
                <?php endforeach; ?>
                <th style="text-align: center">Total Debit</th>
                <th style="text-align: center">Total Credit</th>
            </tr>
        </thead>
        <tbody>
            <?php $debitSums = array(); ?>
            <?php $creditSums = array(); ?>
            <?php foreach ($ledgerSummaryMultipleBranchReportData as $ledgerSummaryMultipleBranchReportDataItem): ?>
                <tr>
                    <td><?php echo CHtml::encode($ledgerSummaryMultipleBranchReportDataItem['code'] . '-' . $ledgerSummaryMultipleBranchReportDataItem['name']); ?></td>
                    <?php $totalDebitSum = '0.00'; ?>
                    <?php $totalCreditSum = '0.00'; ?>
                    <?php foreach ($branches as $branch): ?>
                        <?php $debit = isset($ledgerSummaryMultipleBranchReportDataItem['amounts'][$branch->id]['debit']) ? $ledgerSummaryMultipleBranchReportDataItem['amounts'][$branch->id]['debit'] : '0.00'; ?>
                        <?php $credit = isset($ledgerSummaryMultipleBranchReportDataItem['amounts'][$branch->id]['credit']) ? $ledgerSummaryMultipleBranchReportDataItem['amounts'][$branch->id]['credit'] : '0.00'; ?>
                        <td style="text-align: right">
                            <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0.00', $debit), Yii::app()->createUrl("report/ledgerSummaryMultipleBranch/journalTransaction", array(
                                "CoaId" => $ledgerSummaryMultipleBranchReportDataItem['id'], 
                                "StartDate" => $startDate, 
                                "EndDate" => $endDate, 
                                "BranchId" => $branch->id,
                                "DebetKredit" => 'D',
                            )), array('target' => '_blank')); ?>
                            <?php $totalDebitSum += $debit; ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0.00', $credit), Yii::app()->createUrl("report/ledgerSummaryMultipleBranch/journalTransaction", array(
                                "CoaId" => $ledgerSummaryMultipleBranchReportDataItem['id'], 
                                "StartDate" => $startDate, 
                                "EndDate" => $endDate, 
                                "BranchId" => $branch->id,
                                "DebetKredit" => 'K',
                            )), array('target' => '_blank')); ?>
                            <?php $totalCreditSum += $credit; ?>
                        </td>
                        <?php if (!isset($debitSums[$branch->id])): ?>
                            <?php $debitSums[$branch->id] = '0.00'; ?>
                        <?php endif; ?>
                        <?php if (!isset($creditSums[$branch->id])): ?>
                            <?php $creditSums[$branch->id] = '0.00'; ?>
                        <?php endif; ?>
                        <?php $debitSums[$branch->id] += $debit; ?>
                        <?php $creditSums[$branch->id] += $credit; ?>
                    <?php endforeach; ?>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalDebitSum)); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalCreditSum)); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
<!--        <tfoot>
            <tr>
                <td style="text-align: right; font-weight: bold; border-top: 2px solid; text-transform: uppercase">
                    TOTAL 
                </td>
                <?php /*foreach ($branches as $branch): ?>
                    <td style="text-align: right; font-weight: bold; border-top: 2px solid">
                        <?php $debitSums = isset($debitSums[$branch->id]) ? $debitSums[$branch->id] : '0.00'; ?>
                        <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $debitSums[$branch->id])); ?>
                    </td>

                    <td style="text-align: right; font-weight: bold; border-top: 2px solid">
                        <?php $creditSums = isset($creditSums[$branch->id]) ? $creditSums[$branch->id] : '0.00'; ?>
                        <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $creditSums[$branch->id])); ?>
                    </td>
                <?php endforeach;*/ ?>
            </tr>
        </tfoot>-->
    </table>
</div>