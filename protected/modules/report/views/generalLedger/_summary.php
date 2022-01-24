<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 50% }
	.width1-2 { width: 15% }
	.width1-3 { width: 15% }
	.width1-4 { width: 20% }

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
    <div style="font-size: larger">Laporan Buku Besar</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1" style ="text-align: left;">Akun</th>
        <th class="width1-2" style ="text-align: right;">Total Debit</th>
        <th class="width1-3" style ="text-align: right;">Total Kredit</th>
        <th class="width1-4" style ="text-align: right;">Saldo Akhir</th>

    </tr>
    <tr id="header2">
        <td colspan="4">
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
    <?php foreach ($generalLedgerSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td><?php echo CHtml::encode(CHtml::value($header, 'code')); ?> - <?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
            <td style ="text-align: right;">
                <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getEndDebitLedger($header->id, $startDate, $endDate))); ?>
            </td>
            <td style ="text-align: right;">
                <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getEndCreditLedger($header->id, $startDate, $endDate))); ?>
            </td>
            <td style ="text-align: right;">
                <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getEndBalanceLedger($header->id, $endDate))); ?>
            </td>
        </tr>
        
        <tr class="items2">
            <td colspan="4">
                <table>
                    <tr>
                        <td colspan="6" style="text-align: right; font-weight: bold">Saldo awal</td>
                        <td class="width2-7" style="text-align: right; font-weight: bold">
                            <?php //if ($header->coa_category_id > 5 && $header->coa_category_id < 11): ?>
                                <?php //echo '0'; ?>
                            <?php //else: ?>
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getBeginningBalanceLedger($startDate))); ?>
                            <?php //endif; ?>
                        </td>
                    </tr>
                    <?php foreach ($header->jurnalUmums as $detail): ?>
                        <tr>
                            <td class="width2-1">
                                <?php echo CHtml::link($detail->kode_transaksi, Yii::app()->createUrl("report/generalLedger/redirectTransaction", array("codeNumber" => $detail->kode_transaksi)), array('target' => '_blank')); ?>
                            </td>
                            <td class="width2-2">
                                <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->tanggal_transaksi))); ?>
                            </td>
                            <td class="width2-3">
                                <?php echo CHtml::encode(CHtml::value($detail, 'transaction_subject')); ?>
                            </td>
                            <td class="width2-4">
                                <?php echo CHtml::encode(CHtml::value($detail, 'transaction_type')); ?>
                            </td>
                            <td class="width2-5" style="text-align: right">
                                <?php $debitAmount = $detail->debet_kredit == 'D' ? $detail->total : 0 ?>
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $debitAmount)); ?>
                            </td>
                            <td class="width2-6" style="text-align: right">
                                <?php $creditAmount = $detail->debet_kredit == 'K' ? $detail->total : 0 ?>
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $creditAmount)); ?>
                            </td>
                            <td class="width2-7" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->currentSaldo)); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>