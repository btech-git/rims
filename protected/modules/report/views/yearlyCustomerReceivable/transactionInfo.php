<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 10% }
    .width1-4 { width: 25% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
');
?>

<div class="tab reportTab">
    <div class="tabHead">
        <div style="font-size: larger; font-weight: bold; text-align: center">
            Laporan Piutang Customer <?php echo CHtml::encode(CHtml::value($customer, 'name')); ?>
        </div>
        <div style="font-size: larger; font-weight: bold; text-align: center"><?php echo $monthList[$month] . ' ' . $year; ?></div>
    </div>
    
    <div class="clear"></div>
    <?php echo CHtml::beginForm('', 'get'); ?>
        <div class="row buttons">
            <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
        </div>
    <?php echo CHtml::endForm(); ?>

    <br /> 
    
    <div class="tabBody">
        <table class="report">
            <thead style="position: sticky; top: 0">
                <tr id="header1">
                    <th class="width1-1">Transaksi #</th>
                    <th class="width1-2">Tanggal</th>
                    <th class="width1-3">Note</th>
                    <th class="width1-4">Remarks</th>
                    <th class="width1-5">Debit</th>
                    <th class="width1-6">Credit</th>
                    <th class="width1-7">Saldo</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalDebitSum = '0.00'; ?>
                <?php $totalCreditSum = '0.00'; ?>
                <?php $currentBalance = $beginningBalance; ?>
                <tr>
                    <td colspan="6" style="text-align: right; font-weight: bold"> Saldo Awal</td>
                    <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $beginningBalance)); ?></td>
                </tr>
                <?php foreach($dataProvider->data as $header): ?>
                    <?php $debitAmount = $header->debet_kredit == 'D' ? $header->total : 0; ?>
                    <?php $creditAmount = $header->debet_kredit == 'K' ? $header->total : 0; ?>
                    <?php $currentBalance += $debitAmount - $creditAmount; ?>
                    <tr class="items1">
                        <td><?php echo CHtml::encode(CHtml::value($header, 'kode_transaksi')); ?></td>
                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->tanggal_transaksi))); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'transaction_subject')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($header, 'remark')); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $debitAmount)); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $creditAmount)); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $currentBalance)); ?></td>
                    </tr>
                    <?php $totalDebitSum += $debitAmount; ?>
                    <?php $totalCreditSum += $creditAmount; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold">TOTAL</td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalDebitSum)); ?>
                    </td>
                    <td style="text-align: right; font-weight: bold">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalCreditSum)); ?>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<div>
    <div class="right">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'itemCount' => $dataProvider->pagination->itemCount,
            'pageSize' => $dataProvider->pagination->pageSize,
            'currentPage' => $dataProvider->pagination->getCurrentPage(false),
        )); ?>
    </div>
    <div class="clear"></div>
</div>