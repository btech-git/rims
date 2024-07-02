<div class="relative">
    <div style="font-weight: bold; text-align: center">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <div style="font-size: larger"><?php echo CHtml::encode(($branch === null) ? '' : $branch->name); ?></div>
        <div style="font-size: larger">Laporan Jurnal Umum Rekap <?php echo $transactionTypeLiteral; ?></div>
        <div><?php echo ' YTD: &nbsp;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' - ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
    </div>

    <br />

    <table style="margin: 0 auto; border-spacing: 0pt">
        <thead style="position: sticky; top: 0">
            <tr>
                <th style="text-align: center">COA</th>
                <th style="text-align: center">Debit</th>
                <th style="text-align: center">Credit</th>
            </tr>
        </thead>
        <tbody>
            <?php $totalDebit = '0.00'; ?>
            <?php $totalCredit = '0.00'; ?>
            <?php foreach ($transactionJournalData as $transactionJournalItem): ?>
                <?php $valid = false; ?>
                <?php $valid = $valid || $transactionType === 'PO'; ?>
                <?php $valid = $valid || $transactionType === 'Pout'; ?>
                <?php $valid = $valid || $transactionType === 'Invoice' && (
                    $transactionJournalItem['coa_code'] === '224.00.001' ||
                    preg_match('/^121\.00.+$/', $transactionJournalItem['coa_code']) === 1 ||
                    preg_match('/^411.+$/', $transactionJournalItem['coa_code']) === 1 ||
                    preg_match('/^412.+$/', $transactionJournalItem['coa_code']) === 1 ||
                    preg_match('/^421.+$/', $transactionJournalItem['coa_code']) === 1 ||
                    preg_match('/^422.+$/', $transactionJournalItem['coa_code']) === 1
                ); ?>
                <?php $valid = $valid || $transactionType === 'Pin'; ?>
                <?php $valid = $valid || $transactionType === 'MI' && (
                    preg_match('/^131.+$/', $transactionJournalItem['coa_code']) === 1 ||
                    preg_match('/^132.+$/', $transactionJournalItem['coa_code']) === 1
                ); ?>
                <?php $valid = $valid || $transactionType === 'MO' && (
                    preg_match('/^131.+$/', $transactionJournalItem['coa_code']) === 1 ||
//                    preg_match('/^132.+$/', $transactionJournalItem['coa_code']) === 1 ||
                    preg_match('/^134.+$/', $transactionJournalItem['coa_code']) === 1
                ); ?>
                <?php $valid = $valid || $transactionType === 'CASH'; ?>
                <?php $valid = $valid || $transactionType === 'WOE' && (
                    $transactionJournalItem['coa_code'] === '502.00.001' ||
                    preg_match('/^211\.00.+$/', $transactionJournalItem['coa_code']) === 1
                ); ?>
                <?php $valid = $valid || $transactionType === 'MOM' && (
                    preg_match('/^131\.07.+$/', $transactionJournalItem['coa_code']) === 1 ||
                    preg_match('/^132\.07.+$/', $transactionJournalItem['coa_code']) === 1
                ); ?>
                <?php if ($valid): ?>
                    <tr>
                        <td>
                            <?php echo CHtml::encode($transactionJournalItem['coa_code']); ?> - 
                            <?php echo CHtml::link($transactionJournalItem['coa_name'], Yii::app()->createUrl("report/transactionJournalSummary/jurnalTransaction", array(
                                "CoaId" => $transactionJournalItem['coa_id'], 
                                "StartDate" => $startDate, 
                                "EndDate" => $endDate, 
                                "BranchId" => $branchId,
                                "TransactionType" => $transactionType,
                            )), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $transactionJournalItem['debit'])); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $transactionJournalItem['credit'])); ?></td>
                    </tr>
                    <?php $totalDebit += $transactionJournalItem['debit']; ?>
                    <?php $totalCredit += $transactionJournalItem['credit']; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td style="text-align: right; font-weight: bold; border-top: 2px solid; text-transform: uppercase">
                    TOTAL 
                </td>

                <td style="text-align: right; font-weight: bold; border-top: 2px solid">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalDebit)); ?>
                </td>

                <td style="text-align: right; font-weight: bold; border-top: 2px solid">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalCredit)); ?>
                </td>
            </tr>
        </tfoot>
    </table>
</div>