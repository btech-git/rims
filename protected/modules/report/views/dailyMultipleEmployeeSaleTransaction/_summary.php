<?php
Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 15% }
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
    <div style="font-size: larger">Laporan All Front Harian</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($date))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Front Name</th>
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
    </tr>
    <?php foreach ($dailyMultipleEmployeeSaleReport as $dataItem): ?>
        <?php if (isset($dailyMultipleEmployeeSaleProductReportData[$dataItem['employee_id_sales_person']]) ? $dailyMultipleEmployeeSaleProductReportData[$dataItem['employee_id_sales_person']] : ''): ?>
            <?php $detailItem = $dailyMultipleEmployeeSaleProductReportData[$dataItem['employee_id_sales_person']]; ?>
            <tr class="items1">
                <td><?php echo CHtml::encode($dataItem['employee_name']); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_quantity']); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_new_quantity']); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_repeat_quantity']); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_retail_quantity']); ?></td>
                <td></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['grand_total'])); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['total_service'])); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['total_product'])); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode($detailItem['tire_quantity']); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode($detailItem['oil_quantity']); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode($detailItem['accessories_quantity']); ?></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>