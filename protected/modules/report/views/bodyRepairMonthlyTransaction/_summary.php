<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">
        <?php //$branch = Branch::model()->findByPk($branchId); ?>
        Raperind Motor <?php //echo CHtml::encode(CHtml::value($branch, 'name')); ?>
    </div>
    <div style="font-size: larger">Transaksi Body Repair</div>
    <div><?php echo CHtml::encode(strftime("%B",mktime(0,0,0,$month))); ?> <?php echo CHtml::encode($year); ?></div>
</div>

<br />

<div class="table_wrapper">
    <fieldset>
        <table class="responsive">
            <thead>
                <tr>
                    <th style="text-align: center; width: 10%">Tanggal</th>
                    <th style="text-align: center; width: 10%">Unit In #</th>
                    <th style="text-align: center; width: 10%">Panel In #</th>
                    <th style="text-align: center; width: 10%">Unit Out #</th>
                    <th style="text-align: center; width: 10%">Panel Out #</th>
                    <th style="text-align: center; width: 10%">Sub Pekerjaan Luar</th>
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
                <?php for ($i = 1; $i <= $numberOfDays; $i++): ?>
                    <?php $transactionDate = $year . '-' . $month . '-' . str_pad($i, 2, '0', STR_PAD_LEFT); ?>
                    <?php $registrationVehicleCount = isset($bodyRepairTransactionInfoData[$transactionDate]['registration_vehicle_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['registration_vehicle_count'] : 0; ?>
                    <?php $registrationServiceCount = isset($bodyRepairTransactionInfoData[$transactionDate]['registration_service_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['registration_service_count'] : 0; ?>
                    <?php $invoiceVehicleCount = isset($bodyRepairTransactionInfoData[$transactionDate]['invoice_vehicle_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['invoice_vehicle_count'] : 0; ?>
                    <?php $invoiceServiceCount = isset($bodyRepairTransactionInfoData[$transactionDate]['invoice_service_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['invoice_service_count'] : 0; ?>
                    <?php $workOrderCount = isset($bodyRepairTransactionInfoData[$transactionDate]['work_order_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['work_order_count'] : 0; ?>
                    <?php $workOrderTotal = isset($bodyRepairTransactionInfoData[$transactionDate]['work_order_total']) ? $bodyRepairTransactionInfoData[$transactionDate]['work_order_total'] : '0.00'; ?>
                    <tr>
                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($transactionDate))); ?></td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($registrationVehicleCount), array(
                                '/report/bodyRepairMonthlyTransaction/registrationVehicleInfo', 
                                'transactionDate' => $transactionDate, 
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($registrationServiceCount), array(
                                '/report/bodyRepairMonthlyTransaction/registrationServiceInfo', 
                                'transactionDate' => $transactionDate, 
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($invoiceVehicleCount), array(
                                '/report/bodyRepairMonthlyTransaction/invoiceVehicleInfo', 
                                'transactionDate' => $transactionDate, 
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($invoiceServiceCount), array(
                                '/report/bodyRepairMonthlyTransaction/invoiceServiceInfo', 
                                'transactionDate' => $transactionDate, 
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::link(CHtml::encode($workOrderCount), array(
                                '/report/bodyRepairMonthlyTransaction/workOrderExpenseInfo', 
                                'transactionDate' => $transactionDate, 
                            ), array('target' => '_blank')); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::link(CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $workOrderTotal)), array(
                                '/report/bodyRepairMonthlyTransaction/workOrderExpenseInfo', 
                                'transactionDate' => $transactionDate, 
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
                    <td style="text-align: center"><?php echo CHtml::encode($registrationVehicleCountSum); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($registrationServiceCountSum); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($invoiceVehicleCountSum); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($invoiceServiceCountSum); ?></td>
                    <td style="text-align: center"><?php echo CHtml::encode($workOrderCountSum); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $workOrderTotalSum)); ?></td>
                </tr>
            </tfoot>
        </table>
    </fieldset>
</div>