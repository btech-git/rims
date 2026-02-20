<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 3% }
    .width1-2 { width: 10% }
    .width1-3 { width: 30% }
    .width1-4 { width: 15% }
    .width1-5 { width: 15% }

'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Jurnal Umum (unbalanced)</div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">No</th>
            <th class="width1-2">Tanggal</th>
            <th class="width1-3">Kode Transaksi</th>
            <th class="width1-4">Debit</th>
            <th class="width1-5">Credit</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($balanceErrorReport as $i => $header): ?>
            <tr class="items1">
                <td style="text-align: center"><?php echo CHtml::encode($i + 1); ?></td>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header['transaction_date']))); ?></td>
                <td>
                    <?php echo CHtml::link($header['kode_transaksi'], Yii::app()->createUrl("report/transactionJournal/redirectTransaction", array(
                        "codeNumber" => $header['kode_transaksi']
                    )), array('target' => '_blank')); ?>
                </td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header['debit'])); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header['credit'])); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>