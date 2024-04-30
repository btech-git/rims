<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 15% }
    .width1-3 { width: 15% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 15% }
    .width1-7 { width: 15% }

    .width2-1 { width: 40% }
    .width2-2 { width: 5% }
    .width2-3 { width: 15% }
');
?>

<div class="relative">
    <div style="font-weight: bold; text-align: center">
        <?php //$branch = Branch::model()->findByPk($branchId); ?>
        <div style="font-size: larger">RAPERIND MOTOR<?php //echo CHtml::encode(($branch === null) ? '' : $branch->name); ?></div>
        <div style="font-size: larger">Rincian Buku Besar Pembantu Hutang</div>
        <div>
            <?php //$endDate = date('Y-m-d'); ?>
            <?php echo ' Tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' - ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?>
        </div>
    </div>

    <br />

    <table style="width: 100%; margin: 0 auto; border-spacing: 0pt">
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid; width: 15%">Tanggal</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid; width: 15%">Transaksi #</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Keterangan</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid; width: 15%">Debit</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid; width: 15%">Credit</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid; width: 15%">Saldo</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($payableLedgerSummary->dataProvider->data as $header): ?>
                <?php $payableAmount = $header->getPayableAmount(); ?>
                <?php if ($payableAmount != 0): ?>
                    <tr class="items1">
                        <td colspan="5">
                            <?php echo CHtml::encode(CHtml::value($header, 'code')); ?> - 
                            <?php echo CHtml::encode(CHtml::value($header, 'name')); ?>
                        </td>
                        <td style="text-align: right; font-weight: bold">
                            <?php $saldo = $header->getBeginningBalancePayable($startDate); ?>
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saldo)); ?>
                        </td>
                    </tr>

                    <?php $payableData = $header->getPayableLedgerReport($startDate, $endDate, $branchId); ?>
                    <?php $positiveAmount = 0; ?>
                    <?php $negativeAmount = 0; ?>
                    <?php foreach ($payableData as $payableRow): ?>
                        <?php $transactionNumber = $payableRow['kode_transaksi']; ?>
                        <?php $purchaseAmount = $payableRow['purchase_amount']; ?>
                        <?php $paymentAmount = $payableRow['payment_amount']; ?>
                        <?php $amount = $payableRow['amount']; ?>
                        <?php if ($payableRow['transaction_type'] == 'K'): ?>
                            <?php $saldo += $amount; ?>
                        <?php else: ?>
                            <?php $saldo -= $amount; ?>
                        <?php endif; ?>
                    
                        <tr class="items2">
                            <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($payableRow['tanggal_transaksi']))); ?></td>
                            <td><?php echo CHtml::link($transactionNumber, Yii::app()->createUrl("report/payableLedger/redirectTransaction", array("codeNumber" => $transactionNumber)), array('target' => '_blank')); ?></td>
                            <td><?php echo CHtml::encode($payableRow['remark']); ?></td>
                            <td style="text-align: right">
                                <?php echo $payableRow['transaction_type'] == 'D' ? Yii::app()->numberFormatter->format('#,##0', $amount) : 0; ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo $payableRow['transaction_type'] == 'K' ? Yii::app()->numberFormatter->format('#,##0', $amount) : 0; ?>
                            </td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saldo)); ?></td>
                        </tr>
                        <?php $positiveAmount += $purchaseAmount; ?>
                        <?php $negativeAmount += $paymentAmount; ?>
                    <?php endforeach; ?>

                    <tr>
                        <td colspan="5" style="text-align: right; font-weight: bold">Total Penambahan</td>
                        <td style="text-align: right; font-weight: bold; border-top: 1px solid"><?php echo Yii::app()->numberFormatter->format('#,##0', $negativeAmount); ?></td>
                    </tr>

                    <tr>
                        <td colspan="5" style="text-align: right; font-weight: bold">Total Penurunan</td>
                        <td style="text-align: right; font-weight: bold"><?php echo Yii::app()->numberFormatter->format('#,##0', $positiveAmount); ?></td>
                    </tr>

                    <tr>
                        <td colspan="5" style="text-align: right; font-weight: bold">Perubahan Bersih</td>
                        <td style="text-align: right; font-weight: bold"><?php echo Yii::app()->numberFormatter->format('#,##0', $saldo); ?></td>
                    </tr>

                    <tr>
                        <td colspan="6">&nbsp;</td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>