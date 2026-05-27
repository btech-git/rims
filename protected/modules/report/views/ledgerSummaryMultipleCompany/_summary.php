<div class="relative">
    <div style="font-weight: bold; text-align: center">
        <div style="font-size: larger">Raperind Motor</div>
        <div style="font-size: larger">Ringkasan Buku Besar Semua PT</div>
        <div><?php echo ' YTD: &nbsp;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' - ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
    </div>

    <br />

    <table style="margin: 0 auto; border-spacing: 0pt">
        <thead>
            <tr>
                <th style="text-align: center"></th>
                <?php foreach ($companies as $company): ?>
                    <th style="text-align: center" colspan="2"><?php echo CHtml::encode(CHtml::value($company, 'name')); ?></th>
                <?php endforeach; ?>
                <th colspan="2"></th>
            </tr>
            <tr>
                <th style="text-align: center; min-width: 400px">Chart of Account</th>
                <?php foreach ($companies as $company): ?>
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
            <?php foreach ($ledgerSummaryMultipleCompanyReportData as $ledgerSummaryMultipleCompanyReportDataItem): ?>
                <tr>
                    <td><?php echo CHtml::encode($ledgerSummaryMultipleCompanyReportDataItem['code'] . '-' . $ledgerSummaryMultipleCompanyReportDataItem['name']); ?></td>
                    <?php $totalDebitSum = '0.00'; ?>
                    <?php $totalCreditSum = '0.00'; ?>
                    <?php foreach ($companies as $company): ?>
                        <?php $debit = isset($ledgerSummaryMultipleCompanyReportDataItem['amounts'][$company->id]['debit']) ? $ledgerSummaryMultipleCompanyReportDataItem['amounts'][$company->id]['debit'] : '0.00'; ?>
                        <?php $credit = isset($ledgerSummaryMultipleCompanyReportDataItem['amounts'][$company->id]['credit']) ? $ledgerSummaryMultipleCompanyReportDataItem['amounts'][$company->id]['credit'] : '0.00'; ?>
                        <td style="text-align: right">
                            <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0.00', $debit), Yii::app()->createUrl("report/ledgerSummaryMultipleCompany/journalTransaction", array(
                                "CoaId" => $ledgerSummaryMultipleCompanyReportDataItem['id'], 
                                "StartDate" => $startDate, 
                                "EndDate" => $endDate, 
                                "CompanyId" => $company->id,
                                "DebetKredit" => 'D',
                            )), array('target' => '_blank')); ?>
                            <?php $totalDebitSum += $debit; ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::link(Yii::app()->numberFormatter->format('#,##0.00', $credit), Yii::app()->createUrl("report/ledgerSummaryMultipleCompany/journalTransaction", array(
                                "CoaId" => $ledgerSummaryMultipleCompanyReportDataItem['id'], 
                                "StartDate" => $startDate, 
                                "EndDate" => $endDate, 
                                "CompanyId" => $company->id,
                                "DebetKredit" => 'K',
                            )), array('target' => '_blank')); ?>
                            <?php $totalCreditSum += $credit; ?>
                        </td>
                        <?php if (!isset($debitSums[$company->id])): ?>
                            <?php $debitSums[$company->id] = '0.00'; ?>
                        <?php endif; ?>
                        <?php if (!isset($creditSums[$company->id])): ?>
                            <?php $creditSums[$company->id] = '0.00'; ?>
                        <?php endif; ?>
                        <?php $debitSums[$company->id] += $debit; ?>
                        <?php $creditSums[$company->id] += $credit; ?>
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
                <?php /*foreach ($companyes as $company): ?>
                    <td style="text-align: right; font-weight: bold; border-top: 2px solid">
                        <?php $debitSums = isset($debitSums[$company->id]) ? $debitSums[$company->id] : '0.00'; ?>
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $debitSums[$company->id])); ?>
                    </td>

                    <td style="text-align: right; font-weight: bold; border-top: 2px solid">
                        <?php $creditSums = isset($creditSums[$company->id]) ? $creditSums[$company->id] : '0.00'; ?>
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $creditSums[$company->id])); ?>
                    </td>
                <?php endforeach;*/ ?>
            </tr>
        </tfoot>-->
    </table>
</div>