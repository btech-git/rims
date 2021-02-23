<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 10% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }

    .width2-1 { width: 40% }
    .width2-2 { width: 5% }
    .width2-3 { width: 15% }
    .width2-4 { width: 15% }
');
?>

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
    <thead>
        <tr id="header1">
            <th class="width1-1">No</th>
            <th class="width1-2">Tanggal</th>
            <th class="width1-3">Kode Transaksi</th>
            <th class="width1-4">Keterangan</th>
            <th class="width1-5">Kode COA</th>
            <th class="width1-6">Nama COA</th>
            <th class="width1-7">Debit</th>
            <th class="width1-8">Kredit</th>
        </tr>
    </thead>
    
    <tbody>
        <?php foreach ($jurnalUmumSummary->dataProvider->data as $i => $header): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode($i + 1); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->tanggal_transaksi))); ?></td>
                <td class="width1-3"><?php echo CHtml::link($header->kode_transaksi, Yii::app()->createUrl("accounting/jurnalUmum/redirectTransaction", array("codeNumber" => $header->kode_transaksi)), array('target' => '_blank')); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'transaction_subject')); ?></td>
                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountCode')); ?></td>
                <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountName')); ?></td>
                <td class="width1-7"><?php echo $header->debet_kredit == 'D' ? CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'total'))) : ''; ?></td>
                <td class="width1-8"><?php echo $header->debet_kredit == 'K' ? CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'total'))) : ''; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    
    <tfoot>
        <tr>
            <td></td>
        </tr>
        
        <tr>
            <td></td>
        </tr>
        
    </tfoot>
</table>