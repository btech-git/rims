<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 5% }
    .width1-3 { width: 5% }
    .width1-4 { width: 5% }
    .width1-5 { width: 5% }
    .width1-6 { width: 5% }
    .width1-7 { width: 5% }
    .width1-8 { width: 5% }
    .width1-9 { width: 5% }
    .width1-10 { width: 5% }
    .width1-11 { width: 5% }
    .width1-12 { width: 5% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Laporan Piutang Customer Bulanan</div>
    <div><?php echo CHtml::encode(strftime("%B",mktime(0,0,0,$month))); ?> <?php echo CHtml::encode($year); ?></div>
</div>

<br />

<table class="report">
    <thead>
        <tr id="header1">
            <th class="width1-1">RG #</th>
            <th class="width1-2">RG Date</th>
            <th class="width1-3">Asuransi</th>
            <th class="width1-4">Movement Out</th>
            <th class="width1-5">Parts (Rp)</th>
            <th class="width1-6">Jasa (Rp)</th>
            <th class="width1-7">PPn</th>
            <th class="width1-8">Total</th>
            <th class="width1-9">Invoice</th>
            <th class="width1-10">Outstanding</th>
            <th class="width1-11">Pelunasan</th>
            <th class="width1-12">Payment #</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($monthlyCustomerReceivableSummary->dataProvider->data as $i => $customer): ?>
            <tr class="items1">
                <td colspan="16" style="font-weight: bold; text-align: center"><?php echo CHtml::encode($i + 1); ?> - <?php echo CHtml::encode(CHtml::value($customer, 'name')); ?></td>
            </tr>
            <?php foreach ($monthlyCustomerReceivableReportData[$customer->id] as $dataItem): ?>
                <?php $movementTransactionInfo = isset($monthlyCustomerMovementReportData[$dataItem['id']]) ? $monthlyCustomerMovementReportData[$dataItem['id']] : ''; ?>
                <tr class="items1">
                    <td><?php echo CHtml::encode($dataItem['transaction_number']); ?></td>
                    <td>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($dataItem['transaction_date']))); ?>
                    </td>
                    <td><?php echo CHtml::encode($dataItem['insurance']); ?></td>
                    <td><?php echo CHtml::encode($movementTransactionInfo); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['product_price'])); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['service_price'])); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['ppn_total'])); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['total_price'])); ?></td>
                    <td><?php echo CHtml::encode($dataItem['invoice_number']); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['payment_left'])); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['payment_amount'])); ?></td>
                    <td><?php echo CHtml::encode($dataItem['payment_number']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>