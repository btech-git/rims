<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 5% }
	.width1-2 { width: 50% }
	.width1-3 { width: 20% }

	.width2-1 { width: 17% }
	.width2-2 { width: 12% }
	.width2-3 { width: 15% }
	.width2-4 { width: 20% }
	.width2-5 { width: 12% }
	.width2-6 { width: 12% }
	.width2-7 { width: 12% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Buku Besar <?php echo CHtml::encode($branchId); ?></div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1"></th>
            <th class="width1-2">Akun</th>
            <th class="width1-3" style ="text-align: right;">Saldo Awal</th>
        </tr>
        <tr id="header2">
            <td colspan="3">
                <table>
                    <tr>
                        <th class="width2-1">Transaksi</th>
                        <th class="width2-2">Tanggal</th>
                        <th class="width2-3">Description</th>
                        <th class="width2-4">Memo</th>
                        <th class="width2-5">Debet</th>
                        <th class="width2-6">Kredit</th>
                        <th class="width2-7">Saldo</th>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php $accountNumber = $generalLedgerSummary->dataProvider->pagination->getCurrentPage(false) * $generalLedgerSummary->dataProvider->pagination->pageSize + 1; ?>
        <?php foreach ($generalLedgerSummary->dataProvider->data as $i => $header): ?>
            <?php $beginningBalance = isset($ledgerBeginningBalanceData[$header->id]) ? $ledgerBeginningBalanceData[$header->id] : '0.00'; ?>
            <?php /*$nonZeroValueExists = false; ?>
            <?php if ((int)$beginningBalance > 0): ?>
                <?php $nonZeroValueExists = true; ?>
                <?php break; ?>
            <?php endif; */?>
            <?php //if ((int)$beginningBalance !== 0): ?>
                <tr class="items1">
                    <td><?php echo $accountNumber++; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($header, 'id')); ?> - <?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                    <td style="text-align: right; font-weight: bold">
                        <?php //if ($header->coa_category_id > 5 && $header->coa_category_id < 11): ?>
                            <?php //echo '0'; ?>
                        <?php //else: ?>
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $beginningBalance)); ?>
                        <?php //endif; ?>
                    </td>
                </tr>

                <tr class="items2">
                    <td colspan="3">
                        <table>
                            <?php $totalDebit = 0; ?>
                            <?php $totalCredit = 0; ?>
                            <?php if (isset($generalLedgerReportData[$header->id])): ?>
                                <?php $generalLedgerData = $generalLedgerReportData[$header->id]; ?>
                                <?php $currentBalance = $beginningBalance; ?>
                                <?php foreach ($generalLedgerData as $generalLedgerRow): ?>
                                    <?php $debitAmount = $generalLedgerRow['debet_kredit'] == 'D' ? $generalLedgerRow['total'] : 0; ?>
                                    <?php $creditAmount = $generalLedgerRow['debet_kredit'] == 'K' ? $generalLedgerRow['total'] : 0; ?>
                                    <?php $currentBalance += $debitAmount - $creditAmount; ?>
                                    <tr>
                                        <td class="width2-1">
                                            <?php echo CHtml::link($generalLedgerRow['kode_transaksi'], Yii::app()->createUrl("report/generalLedger/redirectTransaction", array("codeNumber" => $generalLedgerRow['kode_transaksi'])), array('target' => '_blank')); ?>
                                        </td>
                                        <td class="width2-2">
                                            <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($generalLedgerRow['tanggal_transaksi']))); ?>
                                        </td>
                                        <td class="width2-3">
                                            <?php echo CHtml::encode($generalLedgerRow['transaction_subject']); ?>
                                        </td>
                                        <td class="width2-4">
                                            <?php echo CHtml::encode($generalLedgerRow['transaction_type']); ?>
                                        </td>
                                        <td class="width2-5" style="text-align: right">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $debitAmount)); ?>
                                        </td>
                                        <td class="width2-6" style="text-align: right">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $creditAmount)); ?>
                                        </td>
                                        <td class="width2-7" style="text-align: right">
                                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $currentBalance)); ?>
                                        </td>
                                    </tr>
                                    <?php $totalDebit += $debitAmount; ?>
                                    <?php $totalCredit += $creditAmount; ?>
                                <?php endforeach; ?>
                            <?php endif;  ?>
                            <tr>
                                <td colspan="4" style="text-align: right">Total</td>
                                <td class="width2-6" style="text-align: right; border-top: 2px solid">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalDebit)); ?>
                                </td>
                                <td class="width2-7" style="text-align: right; border-top: 2px solid">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalCredit)); ?>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            <?php //endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>