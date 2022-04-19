<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 2% }
    .width1-2 { width: 15% }
    .width1-3 { width: 50% }
    .width1-4 { width: 15% }
    .width1-5 { width: 15% }

');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php $branch = Branch::model()->findByPk($jurnalUmum->branch_id); ?>
        <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Laporan Jurnal Umum</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead>
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
    
    <?php $index = 0; ?>
    <?php $lastId = ''; ?>
    <?php $journalRefs = array(); ?>
    <?php $totalDebit = 0; ?>
    <?php $totalCredit = 0; ?>
    <tbody>
        <?php foreach ($jurnalUmumSummary->dataProvider->data as $i => $header): ?>
            <?php if ($lastId !== $header->kode_transaksi): ?>
                <?php if ($index > 0): ?>
                    <?php foreach ($journalRefs as $journalRef): ?>
                        <tr>
                            <td class="width1-1">&nbsp;</td>
                            <td class="width1-2"><?php echo CHtml::encode($journalRef['code']); ?></td>
                            <td class="width1-3"><?php echo CHtml::encode($journalRef['name']); ?></td>
                            <td class="width1-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $journalRef['debit'])); ?></td>
                            <td class="width1-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $journalRef['credit'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" style="text-align: right; font-weight: bold">TOTAL</td>
                        <td class="width1-4" style="text-align: right; font-weight: bold; border-top: 1px solid">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalDebit)); ?>
                        </td>
                        <td class="width1-5" style="text-align: right; font-weight: bold; border-top: 1px solid">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalCredit)); ?>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php $journalRefs = array(); ?>
                <?php $totalDebit = 0; ?>
                <?php $totalCredit = 0; ?>
        
                <tr class="items1">
                    <td class="width1-1" style="text-align: center"><?php echo CHtml::encode(++$index); ?></td>
                    <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->tanggal_transaksi))); ?></td>
                    <td class="width1-3"><?php echo CHtml::link($header->kode_transaksi, Yii::app()->createUrl("accounting/jurnalUmum/redirectTransaction", array("codeNumber" => $header->kode_transaksi)), array('target' => '_blank')); ?></td>
                    <td colspan="2" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'transaction_subject')); ?></td>
                </tr>
            <?php endif; ?>
                
            <?php $amountDebit = $header->debet_kredit == 'D' ? CHtml::value($header, 'total') : 0; ?>
            <?php $amountCredit = $header->debet_kredit == 'K' ? CHtml::value($header, 'total') : 0; ?>
                
            <?php if (!isset($journalRefs[$header->branchAccountId])): ?>
                <?php $journalRefs[$header->branchAccountId] = array('debit' => 0, 'credit' => 0); ?>
            <?php endif; ?>
            <?php $journalRefs[$header->branchAccountId]['code'] = $header->branchAccountCode; ?>
            <?php $journalRefs[$header->branchAccountId]['name'] = $header->branchAccountName; ?>
            <?php $journalRefs[$header->branchAccountId]['debit'] += $amountDebit; ?>
            <?php $journalRefs[$header->branchAccountId]['credit'] += $amountCredit; ?>
            
            <?php $totalDebit += $amountDebit; ?>
            <?php $totalCredit += $amountCredit; ?>
                
            <?php $lastId = $header->kode_transaksi; ?>
        <?php endforeach; ?>
        <?php foreach ($journalRefs as $journalRef): ?>
            <tr>
                <td class="width1-1">&nbsp;</td>
                <td class="width1-2"><?php echo CHtml::encode($journalRef['code']); ?></td>
                <td class="width1-3"><?php echo CHtml::encode($journalRef['name']); ?></td>
                <td class="width1-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $journalRef['debit'])); ?></td>
                <td class="width1-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $journalRef['credit'])); ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" style="text-align: right; font-weight: bold">TOTAL</td>
            <td class="width1-4" style="text-align: right; font-weight: bold; border-top: 1px solid">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalDebit)); ?>
            </td>
            <td class="width1-5" style="text-align: right; font-weight: bold; border-top: 1px solid">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalCredit)); ?>
            </td>
        </tr>
    </tbody>
</table>