<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 20% }
	.width1-2 { width: 35% }

	.width2-1 { width: 15% }
	.width2-2 { width: 12% }
	.width2-3 { width: 17% }
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
    <thead>
        <tr id="header1">
            <th class="width1-1"">Kode</th>
            <th class="width1-2"">Akun</th>
        </tr>

        <tr id="header2">
            <td colspan="2">
                <table>
                    <tr>
                        <th class="width2-1">Transaksi</th>
                        <th class="width2-2">Tanggal</th>
                        <th class="width2-3">Cabang</th>
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
        <?php foreach ($generalLedgerSummary->dataProvider->data as $header): ?>
            <tr class="items1">
                <td><?php echo CHtml::encode(CHtml::value($header, 'code')); ?></td>
                <td style ="text-align: right;">
                    <?php echo CHtml::encode(CHtml::value($header, 'name')); ?>
                </td>
            </tr>
            
            <tr class="items2">
                <td colspan="2">
                    <table>
                        <tr>
                            <td colspan="6" style="text-align: right; font-weight: bold">Saldo awal</td>
                            <td class="width2-7" style="text-align: right; font-weight: bold">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->getBeginningBalanceLedger($header->id, $startDate))); ?>
                            </td>
                        </tr>
                        <?php foreach ($header->jurnalUmums as $detail): ?>
                            <tr>
                                <td class="width2-1">
                                    <?php echo CHtml::encode(CHtml::value($detail, 'kode_transaksi')); ?>
                                </td>
                                <td class="width2-2">
                                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($detail->tanggal_transaksi))); ?>
                                </td>
                                <td class="width2-3">
                                    <?php echo CHtml::encode(CHtml::value($detail, 'branch.name')); ?>
                                </td>
                                <td class="width2-4">
                                    <?php echo CHtml::encode(CHtml::value($detail, 'transaction_subject')); ?>
                                </td>
                                <td class="width2-5" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->total)); ?>
                                </td>
                                <td class="width2-6" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->total)); ?>
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
    </tbody>
    <tfoot>
        <tr>
            <td></td>
        </tr>
    </tfoot>
</table>