<div class="relative">
    <div style="font-weight: bold; text-align: center">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <div style="font-size: larger"><?php echo CHtml::encode(($branch === null) ? '' : $branch->name); ?></div>
        <div style="font-size: larger">Ringkasan Buku Besar</div>
        <div><?php echo ' YTD: &nbsp;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' - ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
    </div>

    <br />

    <table style="width: 60%; margin: 0 auto; border-spacing: 0pt">
        <thead>
            <tr>
                <th style="text-align: center">Chart of Account</th>
                <th style="text-align: center">Debit</th>
                <th style="text-align: center">Credit</th>
            </tr>
        </thead>
        <tbody>
            <?php $debitSum = '0.00'; ?>
            <?php $creditSum = '0.00'; ?>
            <?php foreach ($ledgerSummaryReport as $ledgerSummaryReportItem): ?>
                <tr>
                    <td>
                        <?php echo CHtml::encode($ledgerSummaryReportItem['coa_code']); ?> - 
                        <?php echo CHtml::link($ledgerSummaryReportItem['coa_name'], Yii::app()->createUrl("report/journalLedgerSummary/jurnalTransaction", array(
                            "CoaId" => $ledgerSummaryReportItem['id'], 
                            "StartDate" => $startDate, 
                            "EndDate" => $endDate, 
                            "BranchId" => $branchId
                        )), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $ledgerSummaryReportItem['debit'])); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $ledgerSummaryReportItem['credit'])); ?></td>
                </tr>
                <?php $debitSum += $ledgerSummaryReportItem['debit']; ?>
                <?php $creditSum += $ledgerSummaryReportItem['credit']; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td style="text-align: right; font-weight: bold; border-top: 2px solid; text-transform: uppercase">
                    TOTAL 
                </td>
                <td style="text-align: right; font-weight: bold; border-top: 2px solid">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $debitSum)); ?>
                </td>
                <td style="text-align: right; font-weight: bold; border-top: 2px solid">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $creditSum)); ?>
                </td>
            </tr>
        </tfoot>
    </table>
</div>