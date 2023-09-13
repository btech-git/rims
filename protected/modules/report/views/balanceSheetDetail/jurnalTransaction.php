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
    <?php $coa = Coa::model()->findByPk($coaId); ?>
    <div><?php echo CHtml::encode($coa->code); ?> - <?php echo CHtml::encode($coa->name); ?></div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))); ?> - <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<div class="clear"></div>

<div class="row buttons">
    <?php /*echo CHtml::hiddenField('CoaId', $coaId); ?>
    <?php echo CHtml::hiddenField('StartDate', $startDate); ?>
    <?php echo CHtml::hiddenField('EndDate', $endDate); ?>
    <?php echo CHtml::hiddenField('BranchId', $branchId); ?>
    <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveToExcel'));*/ ?>
</div>

<?php echo CHtml::endForm(); ?>
<br />

<table class="report">
    <tr>
        <th class="width2-1">No.</th>
        <th class="width2-2">Transaksi</th>
        <th class="width2-3">Tanggal</th>
        <th class="width2-4">Description</th>
        <th class="width2-5">Memo</th>
        <th class="width2-6">Debet</th>
        <th class="width2-7">Kredit</th>
    </tr>
    <?php $totalDebet = '0.00'; ?>
    <?php $totalCredit = '0.00'; ?>
    <?php foreach ($balanceSheetSummary->dataProvider->data as $i => $header): ?>
        <tr>
            <td class="width2-1" style="text-align: center">
                <?php echo $i+1; ?>
            </td>
            <td class="width2-2">
                <?php echo CHtml::link($header->kode_transaksi, Yii::app()->createUrl("report/generalLedger/redirectTransaction", array("codeNumber" => $header->kode_transaksi)), array('target' => '_blank')); ?>
            </td>
            <td class="width2-3">
                <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->tanggal_transaksi))); ?>
            </td>
            <td class="width2-4">
                <?php echo CHtml::encode(CHtml::value($header, 'transaction_subject')); ?>
            </td>
            <td class="width2-5">
                <?php echo CHtml::encode(CHtml::value($header, 'transaction_type')); ?>
            </td>
            <td class="width2-6" style="text-align: right">
                <?php $debitAmount = $header->debet_kredit == 'D' ? $header->total : 0 ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $debitAmount)); ?>
            </td>
            <td class="width2-7" style="text-align: right">
                <?php $creditAmount = $header->debet_kredit == 'K' ? $header->total : 0 ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $creditAmount)); ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan='5' style="text-align: right">Total</td>
        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalDebet)); ?></td>
        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalCredit)); ?></td>
    </tr>
</table>
