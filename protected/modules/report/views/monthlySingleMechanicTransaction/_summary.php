<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 3% }
    .width1-2 { width: 3% }
    .width1-3 { width: 3% }
    .width1-4 { width: 3% }
    .width1-5 { width: 3% }
    .width1-6 { width: 3% }
    .width1-7 { width: 5% }
    .width1-8 { width: 5% }
    .width1-9 { width: 5% }
    .width1-10 { width: 5% }
    .width1-11 { width: 5% }
    .width1-12 { width: 5% }
    .width1-13 { width: 5% }
    .width1-14 { width: 5% }
    .width1-15 { width: 5% }
');
?>

<div style="font-weight: bold; text-align: center">
    <?php $employee = Employee::model()->findByPk($employeeId); ?>
    <div style="font-size: larger">Laporan Penjualan Bulanan <?php echo CHtml::encode(CHtml::value($employee, 'name')); ?></div>
    <div><?php echo CHtml::encode(strftime("%B",mktime(0,0,0,$month))); ?> <?php echo CHtml::encode($year); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Tanggal</th>
        <th class="width1-2">Total Car</th>
        <th class="width1-3">Total WO</th>
        <th class="width1-4">Vehicle System Check</th>
        <th class="width1-5">Retail Customer</th>
        <th class="width1-6">Contract Service Unit</th>
        <th class="width1-7">Total Service</th>
        <th class="width1-8">Total Standard Service Time</th>
        <th class="width1-9">Total Service Time</th>
        <th class="width1-10">Total Service (Rp)</th>
        <th class="width1-11">Average Service (Rp)</th>
    </tr>
    <?php for ($i = 1; $i <= 31; $i++): ?>
        <?php if (isset($monthlySingleMechanicTransactionReportData[$i]) && isset($monthlySingleMechanicTransactionServiceReportData[$i])): ?>
            <?php $dataItem = $monthlySingleMechanicTransactionReportData[$i]; ?>
            <?php $detailItem = $monthlySingleMechanicTransactionServiceReportData[$i]; ?>
            <?php $averageService = $detailItem['service_quantity'] > 0 ? $dataItem['total_service'] / $detailItem['service_quantity'] : '0.00'; ?>
            <tr class="items1">
                <td><?php echo CHtml::encode($dataItem['day']); ?></td>
            <td style="text-align: center"><?php echo CHtml::encode($dataItem['vehicle_quantity']); ?></td>
            <td style="text-align: center"><?php echo CHtml::encode($dataItem['work_order_quantity']); ?></td>
            <td></td>
            <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_retail_quantity']); ?></td>
            <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_company_quantity']); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detailItem['service_quantity'])); ?></td>
            <td></td>
            <td></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['total_service'])); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $averageService)); ?></td>
            </tr>
        <?php else: ?>
            <tr class="items1">
                <td><?php echo $i; ?></td>
                <td colspan="10">&nbsp;</td>
            </tr>
        <?php endif; ?>
    <?php endfor; ?>
</table>