<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 10% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 10% }
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
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid; width: 10%">Tanggal</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid; width: 15%">PO #</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid; width: 15%">Invoice / SJ #</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid; width: 10%">Jatuh Tempo</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid; width: 10%">Total</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid; width: 10%">Pembayaran</th>
                <th style="text-align: center; font-weight: bold; border-bottom: 1px solid; width: 10%">Sisa</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($payableDetailSummary->dataProvider->data as $header): ?>
                <tr class="items1">
                    <td colspan="8">
                        <?php echo CHtml::encode(CHtml::value($header, 'id')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($header, 'name')); ?>
                    </td>
                </tr>

                <?php $payableData = $header->getPayableDetailReport($endDate, $branchId); ?>
                <?php foreach ($payableData as $payableRow): ?>
                    <?php $transactionNumber = $payableRow['purchase_order_no']; ?>
                    <tr class="items2">
                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($payableRow['invoice_date']))); ?></td>
                        <td><?php echo CHtml::link($transactionNumber, Yii::app()->createUrl("report/payableDetail/redirectTransaction", array("codeNumber" => $transactionNumber)), array('target' => '_blank')); ?></td>
                        <td><?php echo CHtml::encode($payableRow['invoice_number']); ?></td>
                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($payableRow['invoice_due_date']))); ?></td>
                        <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $payableRow['invoice_grand_total']); ?></td>
                        <td style="text-align: right"><?php echo Yii::app()->numberFormatter->format('#,##0', $payableRow['payment_amount']); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $payableRow['payment_left'])); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>