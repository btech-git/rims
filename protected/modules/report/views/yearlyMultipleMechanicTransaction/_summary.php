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
    .width1-12 { width: 3% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan All Mechanic Tahunan</div>
    <div><?php echo CHtml::encode($year); ?></div>
</div>

<br />

<table class="report">
    <thead>
    <tr id="header1">
        <th class="width1-12">No</th>
        <th class="width1-1">Mechanic</th>
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
    </thead>
    <tbody>
        <?php $vehicleQuantitySum = 0; ?>
        <?php $workOrderQuantitySum = 0; ?>
        <?php $customerRetailQuantitySum = 0; ?>
        <?php $customerCompanyQuantitySum = 0; ?>
        <?php $quantityServiceSum = 0; ?>
        <?php $totalServiceSum = '0.00'; ?>
        <?php $averageServiceSum = '0.00'; ?>
        <?php foreach ($yearlyMultipleMechanicTransactionReport as $i => $dataItem): ?>
            <?php $detailItem = $yearlyMultipleMechanicTransactionServiceReportData[$dataItem['employee_id_assign_mechanic']]; ?>
            <?php $averageService = $detailItem['service_quantity'] > 0 ? $dataItem['total_service'] / $detailItem['service_quantity'] : '0.00'; ?>
            <tr class="items1">
                <td><?php echo CHtml::encode($i + 1); ?></td>
                <td><?php echo CHtml::encode($dataItem['employee_name']); ?></td>
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
            <?php $vehicleQuantitySum += $dataItem['vehicle_quantity']; ?>
            <?php $workOrderQuantitySum += $dataItem['work_order_quantity']; ?>
            <?php $customerRetailQuantitySum += $dataItem['customer_retail_quantity']; ?>
            <?php $customerCompanyQuantitySum += $dataItem['customer_company_quantity']; ?>
            <?php $quantityServiceSum += $detailItem['service_quantity']; ?>
            <?php $totalServiceSum += $dataItem['total_service']; ?>
            <?php $averageServiceSum += $averageService; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2">TOTAL</td>
            <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $vehicleQuantitySum)); ?></td>
            <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $workOrderQuantitySum)); ?></td>
            <td style="text-align: center"></td>
            <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $customerRetailQuantitySum)); ?></td>
            <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $customerCompanyQuantitySum)); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantityServiceSum)); ?></td>
            <td></td>
            <td></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalServiceSum)); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $averageServiceSum)); ?></td>
        </tr>
    </tfoot>
</table>