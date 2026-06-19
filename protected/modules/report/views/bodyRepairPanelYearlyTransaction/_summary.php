<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        Raperind Motor
    </div>
    <div style="font-size: larger">Body Repair - Panel Report - Yearly</div>
    <div><?php echo CHtml::encode($year); ?></div>
</div>

<br />

<div class="table_wrapper">
    <fieldset>
        <table class="responsive">
            <thead>
                <tr>
                    <th style="text-align: center; width: 10%">Bulan</th>
                    <th style="text-align: center; width: 10%">Unit Register In #</th>
                    <th style="text-align: center; width: 10%">Panel Register In #</th>
                    <th style="text-align: center; width: 10%">Unit Invoiced Out #</th>
                    <th style="text-align: center; width: 10%">Panel Invoiced Out #</th>
                    <th style="text-align: center; width: 10%">Sub Pekerjaan Luar Panel #</th>
                    <th style="text-align: center; width: 10%">Total Sub Pekerjaan</th>
                </tr>
            </thead>

            <tbody>
                <?php $registrationVehicleCountSum = 0; ?>
                <?php $registrationServiceCountSum = 0; ?>
                <?php $invoiceVehicleCountSum = 0; ?>
                <?php $invoiceServiceCountSum = 0; ?>
                <?php $workOrderCountSum = 0; ?>
                <?php $workOrderTotalSum = '0.00'; ?>
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <?php $registrationVehicleCount = isset($bodyRepairYearlyTransactionInfoData[$i]['registration_vehicle_count']) ? $bodyRepairYearlyTransactionInfoData[$i]['registration_vehicle_count'] : 0; ?>
                    <?php $registrationServiceCount = isset($bodyRepairYearlyTransactionInfoData[$i]['registration_service_count']) ? $bodyRepairYearlyTransactionInfoData[$i]['registration_service_count'] : 0; ?>
                    <?php $invoiceVehicleCount = isset($bodyRepairYearlyTransactionInfoData[$i]['invoice_vehicle_count']) ? $bodyRepairYearlyTransactionInfoData[$i]['invoice_vehicle_count'] : 0; ?>
                    <?php $invoiceServiceCount = isset($bodyRepairYearlyTransactionInfoData[$i]['invoice_service_count']) ? $bodyRepairYearlyTransactionInfoData[$i]['invoice_service_count'] : 0; ?>
                    <?php $workOrderCount = isset($bodyRepairYearlyTransactionInfoData[$i]['work_order_service_count']) ? $bodyRepairYearlyTransactionInfoData[$i]['work_order_service_count'] : 0; ?>
                    <?php $workOrderTotal = isset($bodyRepairYearlyTransactionInfoData[$i]['work_order_total']) ? $bodyRepairYearlyTransactionInfoData[$i]['work_order_total'] : '0.00'; ?>
                    <tr>
                        <td><?php echo CHtml::encode($monthList[$i]); ?></td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($registrationVehicleCount), array(
                            'registrationVehicleMonthlyInfo', 
                            'month' => $i,
                            'year' => $year,
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($registrationServiceCount), array(
                            'registrationServiceMonthlyInfo', 
                            'month' => $i,
                            'year' => $year,
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($invoiceVehicleCount), array(
                            'invoiceVehicleMonthlyInfo', 
                            'month' => $i,
                            'year' => $year,
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($invoiceServiceCount), array(
                            'invoiceServiceMonthlyInfo', 
                            'month' => $i,
                            'year' => $year,
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($workOrderCount), array(
                            'workOrderExpensePanelMonthlyInfo', 
                            'month' => $i,
                            'year' => $year,
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $workOrderTotal)), array(
                            'workOrderExpenseAmountMonthlyInfo', 
                            'month' => $i,
                            'year' => $year,
                            ), array('target' => '_blank')); ?>
                        </td>
                    </tr>
                    <?php $registrationVehicleCountSum += $registrationVehicleCount; ?>
                    <?php $registrationServiceCountSum += $registrationServiceCount; ?>
                    <?php $invoiceVehicleCountSum += $invoiceVehicleCount; ?>
                    <?php $invoiceServiceCountSum += $invoiceServiceCount; ?>
                    <?php $workOrderCountSum += $workOrderCount; ?>
                    <?php $workOrderTotalSum += $workOrderTotal; ?>
                <?php endfor; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>TOTAL</td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $registrationVehicleCountSum)), array(
                            'registrationVehicleYearlyInfo', 
                            'year' => $year,
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $registrationServiceCountSum)), array(
                            'registrationServiceYearlyInfo', 
                            'month' => $i,
                            'year' => $year,
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $invoiceVehicleCountSum)), array(
                            'invoiceVehicleYearlyInfo', 
                            'month' => $i,
                            'year' => $year,
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $invoiceServiceCountSum)), array(
                            'invoiceServiceYearlyInfo', 
                            'month' => $i,
                            'year' => $year,
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $workOrderCountSum)), array(
                            'workOrderExpensePanelYearlyInfo', 
                            'month' => $i,
                            'year' => $year,
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $workOrderTotalSum)), array(
                            'workOrderExpenseAmountYearlyInfo', 
                            'month' => $i,
                            'year' => $year,
                        ), array('target' => '_blank')); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </fieldset>
</div>