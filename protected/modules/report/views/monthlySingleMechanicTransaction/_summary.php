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
    <div style="font-size: larger">Laporan Penjualan Bulanan </div>
    <div><?php echo CHtml::encode(CHtml::value($employee, 'name')); ?></div>
    <div><?php echo CHtml::encode(strftime("%B",mktime(0,0,0,$month))); ?> <?php echo CHtml::encode($year); ?></div>
</div>

<br />

<table class="report">
    <thead>
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
    </thead>
    <tbody>
        <?php $vehicleQuantitySum = 0; ?>
        <?php $workOrderQuantitySum = 0; ?>
        <?php $customerRetailQuantitySum = 0; ?>
        <?php $customerCompanyQuantitySum = 0; ?>
        <?php $quantityServiceSum = 0; ?>
        <?php $totalServiceSum = '0.00'; ?>
        <?php $averageServiceSum = '0.00'; ?>
        <?php for ($i = 1; $i <= 31; $i++): ?>
            <?php if (isset($monthlySingleMechanicTransactionReportData[$i]) && isset($monthlySingleMechanicTransactionServiceReportData[$i])): ?>
                <?php $dataItem = $monthlySingleMechanicTransactionReportData[$i]; ?>
                <?php $detailItem = $monthlySingleMechanicTransactionServiceReportData[$i]; ?>
                <?php $averageService = $detailItem['service_quantity'] > 0 ? $dataItem['total_service'] / $detailItem['service_quantity'] : '0.00'; ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['day']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['vehicle_quantity']); ?></td>
                    <td style="text-align: center">
                        <?php echo CHtml::link($dataItem['work_order_quantity'], array(
                            '/report/monthlySingleMechanicTransaction/transactionInfo', 
                            'mechanicId' => $employeeId, 
                            'year' => $year, 
                            'month' => $month, 
                            'day' => $dataItem['day'], 
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_retail_quantity']); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($dataItem['customer_company_quantity']); ?></td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detailItem['service_quantity'])); ?>
                    </td>
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
            <?php else: ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i; ?></td>
                    <td colspan="10">&nbsp;</td>
                </tr>
            <?php endif; ?>
        <?php endfor; ?>
    </tbody>
    <tfoot>
        <tr>
            <td>TOTAL</td>
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