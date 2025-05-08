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
        <?php $branch = Branch::model()->findByPk($branchId); ?>
        <div style="font-size: larger">RAPERIND MOTOR <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?></div>
        <div style="font-size: larger">Hutang Supplier Detail</div>
        <div>
            <?php echo 'Per Tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?>
        </div>
    </div>

    <br />

    <table style="width: 100%; margin: 0 auto; border-spacing: 0pt">
        <thead style="position: sticky; top: 0">
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
            <?php foreach ($payableDetailSummary->dataProvider->data as $header): ?>
                <?php //$payableAmount = $header->getPayableAmount(); ?>
                <?php //if ($payableAmount != 0): ?>
                    <tr class="items1">
                        <td colspan="5">
                            <?php echo CHtml::encode(CHtml::value($header, 'code')); ?> - 
                            <?php echo CHtml::encode(CHtml::value($header, 'name')); ?>
                        </td>
                        <td style="text-align: right; font-weight: bold">
                            <?php $saldo = 0; //$header->getBeginningBalancePayable($startDate); ?>
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saldo)); ?>
                        </td>
                    </tr>

                    <?php $payableData = $header->getPayableDetailReport($endDate, $branchId); ?>
                    <?php foreach ($payableData as $payableRow): ?>
                        <?php $transactionNumber = $payableRow['kode_transaksi']; ?>
                        <?php $amount = $payableRow['amount']; ?>
                        <?php if ($payableRow['transaction_type'] == 'K'): ?>
                            <?php $saldo += $amount; ?>
                        <?php else: ?>
                            <?php $saldo -= $amount; ?>
                        <?php endif; ?>
                    
                        <tr class="items2">
                            <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($payableRow['tanggal_transaksi']))); ?></td>
                            <td><?php echo CHtml::link($transactionNumber, Yii::app()->createUrl("report/payableDetail/redirectTransaction", array("codeNumber" => $transactionNumber)), array('target' => '_blank')); ?></td>
                            <td><?php echo CHtml::encode($payableRow['remark']); ?></td>
                            <td style="text-align: right">
                                <?php echo $payableRow['transaction_type'] == 'D' ? Yii::app()->numberFormatter->format('#,##0', $amount) : 0; ?>
                            </td>
                            <td style="text-align: right">
                                <?php echo $payableRow['transaction_type'] == 'K' ? Yii::app()->numberFormatter->format('#,##0', $amount) : 0; ?>
                            </td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saldo)); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php //endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>