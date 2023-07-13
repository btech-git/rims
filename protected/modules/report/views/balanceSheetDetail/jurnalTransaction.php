<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 20% }
	.width1-2 { width: 50% }

	.width2-1 { width: 5% }
	.width2-2 { width: 15% }
	.width2-3 { width: 12% }
	.width2-4 { width: 20% }
	.width2-5 { width: 20% }
	.width2-6 { width: 12% }
	.width2-7 { width: 12% }
');
?>

<?php echo CHtml::beginForm(array(''), 'get'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Transaction Detail</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))); ?> - <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<div class="clear"></div>

<div class="row buttons">
    <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveToExcel')); ?>
</div>

<?php echo CHtml::endForm(); ?>
<br />

<table class="report">
    <tr id="coa1">
        <th class="width1-1">Kode</th>
        <th class="width1-2">Nama Akun</th>
    </tr>
    <tr id="coa2">
        <td colspan="2">
            <table>
                <tr>
                    <th class="width2-1">No.</th>
                    <th class="width2-2">Transaksi</th>
                    <th class="width2-3">Tanggal</th>
                    <th class="width2-4">Description</th>
                    <th class="width2-5">Memo</th>
                    <th class="width2-6">Debet</th>
                    <th class="width2-7">Kredit</th>
                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($balanceSheetSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td><?php echo CHtml::encode(CHtml::value($header, 'code')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
        </tr>
        
        <tr class="items2">
            <td colspan="2">
                <table>
                    <?php foreach ($header->jurnalUmums as $i=>$detail): ?>
                        <?php if ((int) $detail->is_coa_category == 0): ?>
                            <tr>
                                <td class="width2-1" style="text-align: center">
                                    <?php echo $i+1; ?>
                                </td>
                                <td class="width2-2">
                                    <?php echo CHtml::link($detail->kode_transaksi, Yii::app()->createUrl("report/generalLedger/redirectTransaction", array("codeNumber" => $detail->kode_transaksi)), array('target' => '_blank')); ?>
                                </td>
                                <td class="width2-3">
                                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->tanggal_transaksi))); ?>
                                </td>
                                <td class="width2-4">
                                    <?php echo CHtml::encode(CHtml::value($detail, 'transaction_subject')); ?>
                                </td>
                                <td class="width2-5">
                                    <?php echo CHtml::encode(CHtml::value($detail, 'transaction_type')); ?>
                                </td>
                                <td class="width2-6" style="text-align: right">
                                    <?php $debitAmount = $detail->debet_kredit == 'D' ? $detail->total : 0 ?>
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $debitAmount)); ?>
                                </td>
                                <td class="width2-7" style="text-align: right">
                                    <?php $creditAmount = $detail->debet_kredit == 'K' ? $detail->total : 0 ?>
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $creditAmount)); ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
