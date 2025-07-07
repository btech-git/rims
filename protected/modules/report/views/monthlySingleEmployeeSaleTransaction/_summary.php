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
        <th class="width1-2">Customer Total</th>
        <th class="width1-3">Baru</th>
        <th class="width1-4">Repeat</th>
        <th class="width1-5">Retail</th>
        <th class="width1-6">Contract Service Unit</th>
        <th class="width1-7">Total Invoice (Rp)</th>
        <th class="width1-8">Service (Rp)</th>
        <th class="width1-9">Parts (Rp)</th>
        <th class="width1-10">Total Ban</th>
        <th class="width1-11">Total Oli</th>
        <th class="width1-12">Total Aksesoris</th>
        <th class="width1-13">Average Ban</th>
        <th class="width1-14">Average Oli</th>
        <th class="width1-15">Average Aksesoris</th>
    </tr>
    <?php for ($i = 1; $i <= 31; $i++): ?>
        <?php if (isset($monthlySingleEmployeeSaleReportData[$i]) && isset($monthlySingleEmployeeSaleProductReportData[$i])): ?>
            <?php $dataItem = $monthlySingleEmployeeSaleReportData[$i]; ?>
            <?php $detailItem = $monthlySingleEmployeeSaleProductReportData[$i]; ?>
            <?php $averageTire = $detailItem['tire_quantity'] > 0 ? $detailItem['tire_price'] / $detailItem['tire_quantity'] : '0.00'; ?>
            <?php $averageOil = $detailItem['oil_quantity'] > 0 ? $detailItem['oil_price'] / $detailItem['oil_quantity'] : '0.00'; ?>
            <?php $averageAccessories = $detailItem['accessories_quantity'] > 0 ? $detailItem['accessories_price'] / $detailItem['accessories_quantity'] : '0.00'; ?>
            <tr class="items1">
                <td><?php echo CHtml::encode($dataItem['day']); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_quantity']); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_new_quantity']); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_repeat_quantity']); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_retail_quantity']); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_company_quantity']); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['grand_total'])); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['total_service'])); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['total_product'])); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode($detailItem['tire_quantity']); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode($detailItem['oil_quantity']); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode($detailItem['accessories_quantity']); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $averageTire)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $averageOil)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $averageAccessories)); ?></td>
            </tr>
        <?php else: ?>
            <tr class="items1">
                <td><?php echo $i; ?></td>
                <td colspan="14"></td>
            </tr>
        <?php endif; ?>
    <?php endfor; ?>
</table>