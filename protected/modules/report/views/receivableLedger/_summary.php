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
        <div style="font-size: larger">Rincian Buku Besar Pembantu Piutang</div>
        <div>
            <?php //$endDate = date('Y-m-d'); ?>
            <?php echo ' Tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' - ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?>
        </div>
    </div>

    <br />

    <table style="width: 80%; margin: 0 auto; border-spacing: 0pt">
        <thead>
            <tr>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Tanggal</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Jenis Transaksi</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Transaksi #</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Keterangan</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Nilai</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid">Saldo</th>
            </tr>
        </thead>
        
        <tbody>
            <?php /*foreach ($receivableLedgerSummary->dataProvider->data as $header): ?>
                <?php $saldo = 0; //$header->getBeginningBalanceReceivable($startDate); ?>
                <?php //if ($saldo > 0.00): ?>
                    <tr class="items1">
                        <td colspan="5"><?php echo CHtml::encode(CHtml::value($header, 'id')); ?> - <?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>

                        <td style="text-align: right; font-weight: bold">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saldo)); ?>
                        </td>
                    </tr>

                    <?php $receivableData = array(); //$header->getReceivableLedgerReport($startDate, $endDate); ?>
                    <?php $positiveAmount = 0; ?>
                    <?php $negativeAmount = 0; ?>
                    <?php foreach ($receivableData as $receivableRow): ?>
                        <?php $transactionNumber = $receivableRow['transaction_number']; ?>
                        <?php $saleAmount = $receivableRow['sale_amount']; ?>
                        <?php $paymentAmount = $receivableRow['payment_amount']; ?>
                        <?php $amount = $receivableRow['amount']; ?>
                        <?php $saldo += $amount; ?>
                        <tr class="items2">
                            <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($receivableRow['transaction_date']))); ?></td>
                            <td><?php echo CHtml::encode($receivableRow['transaction_type']); ?></td>
                            <td><?php echo CHtml::link($transactionNumber, Yii::app()->createUrl("report/receivableLedger/redirectTransaction", array("codeNumber" => $transactionNumber)), array('target' => '_blank')); ?></td>
                            <td><?php echo CHtml::encode($receivableRow['remark']); ?></td>
                            <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $amount); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saldo)); ?></td>
                        </tr>
                        <?php $positiveAmount += $saleAmount; ?>
                        <?php $negativeAmount += $paymentAmount; ?>
                    <?php endforeach; ?>

                    <tr>
                        <td colspan="4" style="text-align: right; font-weight: bold">Total Penambahan</td>
                        <td style="text-align: right; font-weight: bold; border-top: 1px solid"><?php echo Yii::app()->numberFormatter->format('#,##0', $positiveAmount); ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: right; font-weight: bold">Total Penurunan</td>
                        <td style="text-align: right; font-weight: bold"><?php echo Yii::app()->numberFormatter->format('#,##0', $negativeAmount); ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: right; font-weight: bold">Perubahan Bersih</td>
                        <?php $differenceAmount = $positiveAmount + $negativeAmount; ?>
                        <td style="text-align: right; font-weight: bold"><?php echo Yii::app()->numberFormatter->format('#,##0', $saldo); ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="6">&nbsp;</td>
                    </tr>
                <?php //endif; ?>
            <?php endforeach;*/ ?>
        </tbody>
    </table>
</div>