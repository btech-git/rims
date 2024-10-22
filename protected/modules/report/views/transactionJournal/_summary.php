<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 2% }
    .width1-2 { width: 15% }
    .width1-3 { width: 50% }
    .width1-4 { width: 15% }
    .width1-5 { width: 15% }

'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Laporan Jurnal Umum</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">No</th>
            <th class="width1-2">Tanggal</th>
            <th class="width1-3">Kode Transaksi</th>
            <th colspan="2">Keterangan</th>
        </tr>
        
        <tr id="header2">
            <th>&nbsp;</th>
            <th class="width1-2">Kode COA</th>
            <th class="width1-3">Nama COA</th>
            <th class="width1-4">Debit</th>
            <th class="width1-5">Kredit</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transactionJournalReport as $i => $header): ?>
            <?php $totalDebit = 0; ?>
            <?php $totalCredit = 0; ?>
            <tr class="items1">
                <td class="width1-1" style="text-align: center"><?php echo CHtml::encode($i + 1); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header['transaction_date']))); ?></td>
                <td class="width1-3">
                    <?php echo CHtml::link($header['kode_transaksi'], Yii::app()->createUrl("report/transactionJournal/redirectTransaction", array(
                        "codeNumber" => $header['kode_transaksi']
                    )), array('target' => '_blank')); ?>
                </td>
                <td colspan="2" style="text-align: center"><?php echo CHtml::encode($header['transaction_subject']); ?></td>
            </tr>
            <?php foreach ($transactionJournalReportData[$header['kode_transaksi']] as $transactionJournalItemData): ?>
                <?php $debitAmount = $transactionJournalItemData->debet_kredit == 'D' ? $transactionJournalItemData->total : 0; ?>
                <?php $creditAmount = $transactionJournalItemData->debet_kredit == 'K' ? $transactionJournalItemData->total : 0; ?>
                <tr>
                    <td class="width1-1">&nbsp;</td>
                    <td class="width1-2"><?php echo CHtml::encode(CHtml::value($transactionJournalItemData, 'coa.code')); ?></td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($transactionJournalItemData, 'coa.name')); ?></td>
                    <td class="width1-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $debitAmount)); ?></td>
                    <td class="width1-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $creditAmount)); ?></td>
                </tr>
                <?php $totalDebit += $debitAmount; ?>
                <?php $totalCredit += $creditAmount; ?>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold">TOTAL</td>
                <?php $textColor = Yii::app()->numberFormatter->format('#,##0.00', $totalDebit) !== Yii::app()->numberFormatter->format('#,##0.00', $totalCredit) ? 'red' : 'black'; ?>
                <?php $textError = Yii::app()->numberFormatter->format('#,##0.00', $totalDebit) !== Yii::app()->numberFormatter->format('#,##0.00', $totalCredit) ? 'err' : ''; ?>
                <td class="width1-4" style="text-align: right; font-weight: bold; border-top: 1px solid; color: <?php echo $textColor; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalDebit)); ?>
                </td>
                <td class="width1-5" style="text-align: right; font-weight: bold; border-top: 1px solid; color: <?php echo $textColor; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalCredit)); ?> <?php echo $textError; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>