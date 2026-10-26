<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div style="font-weight: bold; text-align: center">
    <?php $employee = Employee::model()->findByPk($employeeId); ?>
    <div style="font-size: larger">Raperind Motor</div>
    <div>Penjualan Bulanan <?php echo CHtml::encode(CHtml::value($employee, 'name')); ?></div>
    <div><?php echo CHtml::encode(strftime("%B",mktime(0,0,0,$month))); ?> <?php echo CHtml::encode($year); ?></div>
</div>

<br />

<div class="table_wrapper">
    <table class="responsive">
        <thead>
            <tr id="header1">
                <th>Tanggal</th>
                <th>Total Car</th>
                <th>Total WO</th>
                <th>Vehicle System Check</th>
                <th>Retail Customer</th>
                <th>Contract Service Unit</th>
                <th>Total Service</th>
                <th>Total Standard Service Time</th>
                <th>Total Service Time</th>
                <th>Total Service (Rp)</th>
                <th>Average Service (Rp)</th>
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
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detailItem['service_quantity'])); ?>
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
</div>