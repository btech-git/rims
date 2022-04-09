<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 3% }
    .width1-2 { width: 10% }
    .width1-3 { width: 10% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }

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
    
    <?php $lastId = ''; $nomor = 1;?>
    <tbody>
        <?php foreach ($jurnalUmumSummary->dataProvider->data as $i => $header): ?>
            <?php if ($lastId !== $header->kode_transaksi): ?>
                <?php $totalDebit = 0; $totalCredit = 0; $index = 1; ?>
                <?php /*$transactions = JurnalUmum::model()->findAllByAttributes(array('kode_transaksi' => $header->kode_transaksi, 'is_coa_category' => 0)); ?>
                <?php $totalTransaction = count($transactions);*/ ?>
        
                <tr class="items1">
                    <td class="width1-1" style="text-align: center"><?php echo CHtml::encode($nomor); ?></td>
                    <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->tanggal_transaksi))); ?></td>
                    <td class="width1-3"><?php echo CHtml::link($header->kode_transaksi, Yii::app()->createUrl("accounting/jurnalUmum/redirectTransaction", array("codeNumber" => $header->kode_transaksi)), array('target' => '_blank')); ?></td>
                    <td colspan="2" style="text-align: center"><?php echo CHtml::encode(CHtml::value($header, 'transaction_subject')); ?></td>
                    <?php $nomor++; ?>
                </tr>
            <?php endif; ?>
                
            <?php $amountDebit = $header->debet_kredit == 'D' ? CHtml::value($header, 'total') : 0; ?>
            <?php $amountCredit = $header->debet_kredit == 'K' ? CHtml::value($header, 'total') : 0; ?>
            
            <tr>
                <td class="width1-1">&nbsp;</td>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountCode')); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountName')); ?></td>
                <td class="width1-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountDebit)); ?></td>
                <td class="width1-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amountCredit)); ?></td>
            </tr>
            
            <?php $totalDebit += $amountDebit; ?>
            <?php $totalCredit += $amountCredit; ?>
            
            <?php //if ($index == $totalTransaction): ?>
            <?php if ($lastId === $header->kode_transaksi): ?>
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
                
            <?php $nomor++; ?>
            <?php $lastId = $header->kode_transaksi; ?>
        <?php endforeach; ?>
    </tbody>
</table>