<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][accountingReport]", CHtml::resolveValue($model, "roles[accountingReport]"), array('id' => 'User_roles_' . $counter, 'value' => 'accountingReport')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">View</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Rincian Buku Besar Pembantu Hutang</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][payableJournalReport]", CHtml::resolveValue($model, "roles[payableJournalReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'payableJournalReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Buku Besar Pembantu Piutang</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][receivableJournalReport]", CHtml::resolveValue($model, "roles[receivableJournalReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'receivableJournalReport')); ?>
            </td>
        </tr>
        <tr>
            <td>General Ledger</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][generalLedgerReport]", CHtml::resolveValue($model, "roles[generalLedgerReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'generalLedgerReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Balance Sheet (Induk)</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][summaryBalanceSheetReport]", CHtml::resolveValue($model, "roles[summaryBalanceSheetReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'summaryBalanceSheetReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Balance Sheet (Standard)</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][standardBalanceSheetReport]", CHtml::resolveValue($model, "roles[standardBalanceSheetReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'standardBalanceSheetReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Profit/Loss (induk)</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][summaryProfitLossReport]", CHtml::resolveValue($model, "roles[summaryProfitLossReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'summaryProfitLossReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Profit/Loss (Standar)</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][standardProfitLossReport]", CHtml::resolveValue($model, "roles[standardProfitLossReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'standardProfitLossReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Cash Transaction</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][cashTransactionReport]", CHtml::resolveValue($model, "roles[cashTransactionReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashTransactionReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Analisa Keuangan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][financialAnalysisReport]", CHtml::resolveValue($model, "roles[financialAnalysisReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'financialAnalysisReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Kertas Kerja</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][kertasKerjaReport]", CHtml::resolveValue($model, "roles[kertasKerjaReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'kertasKerjaReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Jurnal Umum</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][transactionJournalReport]", CHtml::resolveValue($model, "roles[transactionJournalReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'transactionJournalReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Jurnal Umum Rekap</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][journalSummaryReport]", CHtml::resolveValue($model, "roles[journalSummaryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'journalSummaryReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Laporan Kas Harian</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][cashDailyReport]", CHtml::resolveValue($model, "roles[cashDailyReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashDailyReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Approval Kas Harian</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][cashDailyApprovalReport]", CHtml::resolveValue($model, "roles[cashDailyApprovalReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashDailyApprovalReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Summary Kas Harian</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][cashDailySummaryReport]", CHtml::resolveValue($model, "roles[cashDailySummaryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashDailySummaryReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Financial Forecast</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][financialForecastReport]", CHtml::resolveValue($model, "roles[financialForecastReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'financialForecastReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Kas Harian Transaksi</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][cashDailyTransactionReport]", CHtml::resolveValue($model, "roles[cashDailyTransactionReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashDailyTransactionReport')); ?>
            </td>
        </tr>
    </tbody>
</table>